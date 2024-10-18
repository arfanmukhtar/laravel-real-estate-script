<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function searchResult(Request $request)
    {
        
        $load_more_count = getSetting('load_more_count');
        $custom_data = $request->input('custom_data');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $sort_by = $request->input('sort_by');
        $query = trim($request->input('search'));
        $categories = urldecode($request->input('categories'));
        $locations = urldecode($request->input('locations'));
        $locationArea = urldecode($request->input('subareas'));
        $subCategory = urldecode($request->input('subcategories'));
        $city_ids = [];
        $category_ids = [];
        $total_count = 0;
        if (isset($categories)) {
            $category_names = explode('/', $categories);
            $category_ids = \App\Models\Category::whereIn('slug', $category_names)->pluck('id');
        }

        if (isset($locations) and ! empty($locations)) {
            $city_names = explode('/', $locations);
            $city_ids = \App\Models\City::whereIn('slug', $city_names)->pluck('id');
        }

        $skip = ! empty($request->input('skip')) ? $request->input('skip') : 0;
        $posts = \App\Models\Post::with('mainPhoto')->whereNotNull('slug');
        if (! empty($query)) {
            $posts->where('title', 'like', "%{$query}%");
        }
        if (count($city_ids) > 0) {
            $city_ids = json_decode(json_encode($city_ids), true);
            $posts->whereIn('city_id', $city_ids);
        }
        if (isset($locationArea) and ! empty($locationArea)) {
            $location_areas = explode('/', $locationArea);
            if (! empty($location_areas)) {
                $posts->whereIn('area_id', $location_areas);
            }
        }

        if (isset($subCategory) and ! empty($subCategory)) {
            $sub_categories = explode('/', $subCategory);
            if (! empty($sub_categories)) {
                $posts->whereIn('category_id', $sub_categories);
            }
            $category_ids = json_decode(json_encode($category_ids), true);
        } else {
            if (count($category_ids) > 0) {
                $category_ids = json_decode(json_encode($category_ids), true);
                $childCategories = \App\Models\Category::whereIn('parent_id', $category_ids)->pluck('id');

                if (count($childCategories) > 0) {
                    $childCategories = $childCategories->toArray();
                    $categoryIds = array_merge($category_ids, $childCategories);
                } else {
                    $categoryIds = $category_ids;
                }

                $posts->whereIn('category_id', $categoryIds);
            }
        }

        if ($maxPrice > 0 and $minPrice > 0) {
            $posts->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($maxPrice > 0) {
            $posts->where('price', '<', $maxPrice);
        } elseif ($minPrice > 0) {
            $posts->where('price', '>', $minPrice);
        }

         //// Custom fields Check 
        if(!empty($custom_data)) { 
            parse_str($custom_data, $customDataArray);
            foreach($customDataArray as $key=>$cda) {
                if(is_array($cda) and !empty($cda["min"])) { 
                    $posts->whereBetween("custom_data->$key" , [$cda['min'], $cda['max']]);
                }
            }
        }

        

        if ($sort_by > 1) {
            if ($sort_by == 2) {
                $posts->orderBy('price', 'ASC');
            }
            if ($sort_by == 3) {
                $posts->orderBy('price', 'DESC');
            }
            if ($sort_by == 4) {
                $posts->orderBy('created_at', 'DESC');
            }
            if ($sort_by == 5) {
                $posts->orderBy('created_at', 'ASC');
            }
        } else { 
            $posts->orderBy('created_at', 'DESC');
        }

        if ($skip == 0) {
            $total_count = $posts->count();
        }

        $posts = $posts->skip($skip)->take($load_more_count)->get();
        if ($posts->isEmpty()) {
            return 'noresult';
        }

        // return response()->json($posts, Response::HTTP_OK);
        return view('ads.searchResult', compact('posts', 'total_count'));
    }

    public function checkSubCat(Request $request)
    {
        $html = '';
        $categoriesIds = $request->input('categoriesIds');
        $sub_categories = $request->input('sub_categories');
        if (! is_array($categoriesIds)) {
            $categoriesIds = json_decode($categoriesIds, true);
        }
        if (! is_array($sub_categories)) {
            $sub_categories = json_decode($sub_categories, true);
        }
        if (! empty($categoriesIds)) {
            $childCategories = \App\Models\Category::whereIn('parent_id', $categoriesIds)->get();
            foreach ($childCategories as $category) {
                $cSelected = '';
                if (in_array($category->id, $sub_categories)) {
                    $cSelected = 'checked';
                }
                $html .= "<li> <input data-name='".$category->name."' data-id='".$category->id."' class='subCategoryList'".$cSelected." type='checkbox' value='".$category->slug."' name='sc' id='subCat".$category->id."'><label for='subCat".$category->id."' class='title text-link'> ".$category->name." </label><span class='count'><small> ".$category->counter.'</small></span></li>';
            }
        }

        echo $html;
    }

    public function checkSubAreas(Request $request)
    {
        $html = '';
        $locationsIds = $request->input('locationsIds');
        if (! is_array($locationsIds)) {
            $locationsIds = json_decode($locationsIds, true);
        }
        if (! empty($locationsIds)) {

            $childCategories = \App\Models\cityArea::whereIn('city_id', $locationsIds)->orderBy('counter')->get();
            foreach ($childCategories as $category) {
                $cSelected = '';
                if (in_array($category->id, $locationsIds)) {
                    $cSelected = 'checked';
                }
                $html .= "<li> <input data-name='".$category->name."' data-id='".$category->id."' class='areaList'".$cSelected." type='checkbox' value='".$category->slug."' name='la' id='area_".$category->id."'><label for='area_".$category->id."' class='title text-link'> ".$category->name." </label><span class='count'><small> ".$category->counter.'</small></span></li>';
            }
        }

        echo $html;
    }
}
