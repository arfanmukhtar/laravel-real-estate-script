
@if(empty($post_detail))
<div class="content-subheading"><i class="icon-user fa"></i> <strong>{{ trans('custom_fields.aditional_information') }}</strong></div>
@endif
<div class="form-group row">
   <label class="col-sm-2 col-form-label" for="Bedrooms">Area Size</label>
   <div class="col-sm-3">
       <input id="area_size" @if(!empty($post_detail) and !empty($post_detail->area_size)) value="{{$post_detail->area_size}}" @endif name="area_size"  class="form-control input-md"  type="number">
   </div>
   <div class="col-sm-3">
       <select name="area_size_type" id="area_size_type" class="select2 form-control">
           <option @if(!empty($post_detail) and $post_detail->area_size_type == "Marla") selected @endif value="Marla">Marla</option>
           <option @if(!empty($post_detail) and $post_detail->area_size_type == "sq_ft") selected @endif value="sq_ft">Sq. Ft.</option>
           <option @if(!empty($post_detail) and $post_detail->area_size_type == "sq_m") selected @endif value="sq_m">Sq. M.</option>
           <option @if(!empty($post_detail) and $post_detail->area_size_type == "sq_yd") selected @endif value="sq_yd">Sq. Yd.</option>
           <option @if(!empty($post_detail) and $post_detail->area_size_type == "kanal") selected @endif value="kanal">Kanal</option>
          
       </select>
   </div>
 </div>


 <div class="form-group row">
   <label class="col-sm-2 col-form-label" for="Bedrooms">Bed & Bath</label>
   <div class="col-sm-3">
       <select name="bedrooms" id="bedrooms" class="select2 form-control">
           <option value="0">Bed</option>
           @for($i=1; $i <= 10; $i++)
               <option @if(!empty($post_detail) and $post_detail->bedrooms == $i) selected @endif value="{{$i}}">{{$i}}</option>
           @endfor
       </select>
   </div>
   <div class="col-sm-3">
       <select name="bathrooms" id="bathrooms" class="select2 form-control">
           <option value="0">Bath</option>
           @for($i=1; $i <= 10; $i++)
               <option @if(!empty($post_detail) and $post_detail->bathrooms == $i) selected @endif  value="{{$i}}">{{$i}}</option>
           @endfor
       </select>
   </div>
 </div>


 <div class="form-group row">
   <label class="col-sm-2 col-form-label" for="Bedrooms">Build Year</label>
   <div class="col-sm-3">
       <input id="build_year" @if(!empty($post_detail) and !empty($post_detail->build_year)) value="{{$post_detail->build_year}}" @endif name="build_year"  class="form-control input-md"  type="number">
   </div>
   <label class="col-sm-2 col-form-label" for="Bedrooms">Number of Story</label>
   <div class="col-sm-3">
       <input id="number_of_stories" name="number_of_stories" @if(!empty($post_detail) and !empty($post_detail->number_of_stories)) value="{{$post_detail->number_of_stories}}" @endif  class="form-control input-md"  type="number">
   </div>
 </div>

@if(!empty($custom_fields))
@foreach($custom_fields as $field)
    @php $required = ""; 
        $postData = json_decode($post->custom_data , true);
    @endphp
   @if($field->type == "text")
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>

       <div class="col-sm-8">
           <input id="seller_name" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif name="custom[{{$field->id}}]"  class="form-control input-md" {{$required}}  type="text">
       </div>
   </div>
   @endif
   @if($field->type == "dropbox")
   <div class="form-group row">
   <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <?php 
           $options = json_decode($field->options , true);
       ?>
       <div class="col-sm-8">
           <select class="form-control input-md" name="custom[{{$field->id}}]"  >
               @foreach($options as $option)
               <option value="{{$option}}" @if(!empty($postData[$field->id]) and $postData[$field->id] == $option) selected @endif>{{$option}}</option>
               @endforeach
           </select>
       </div>
   </div>
   @endif
   @if($field->type == "checkbox")
   <div class="form-group row">
       <label for="{{$field->name}}" class="col-sm-2 col-form-label" >{{$field->name}}</label>
       <?php 
           $options = json_decode($field->options , true);
       ?>
       
       <div class="col-sm-8">
           @foreach($options as $option)
                @php 
                $checked = "";
                if(is_array($postData[$field->id])) { 
                    $selectedData = $postData[$field->id];
                    if(in_array($option , $selectedData))  $checked = "checked";
                } else { 
                    if(!empty($postData[$field->id]) and $postData[$field->id] == $option) { 
                        $checked = "checked";
                    }
                }
                @endphp
               <div class="form-check form-check-inline">
                   <label class="form-check-label">
                       <input class="form-check-input" type="checkbox" {{$checked}}  name="custom[{{$field->id}}][]"   value="{{$option}}"> {{$option}}
                   </label>
               </div>
           @endforeach
          
       </div>
   </div>
   @endif

   @if($field->type == "radio")
   <div class="form-group row">
       <label for="{{$field->name}}" class="col-sm-3 col-form-label" >{{$field->name}}</label>
       <?php 
           $options = json_decode($field->options , true);
       ?>
       <div class="col-sm-8">
           @foreach($options as $option)
               <div class="form-check form-check-inline">
                   <label class="form-check-label">
                       <input class="form-check-input" type="radio" @if(!empty($postData[$field->id]) and $postData[$field->id] == $option) checked @endif  name="custom[{{$field->id}}]"   value="{{$option}}"> {{$option}}
                   </label>
               </div>
           @endforeach
          
       </div>
   </div>
   @endif
   @if($field->type == "textarea")
   @php 
   $textData = "";
        if(!empty($postData[$field->id])) $textData = $postData[$field->id];
    @endphp
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <div class="col-sm-8">
           <textarea  name="custom[{{$field->id}}]"   class="form-control input-md" rows="3" {{$required}}  type="text">{{$textData}}</textarea>
       </div>
   </div>
   @endif
   @if($field->type == "number")
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <div class="col-sm-8">
           <input  name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif  class="form-control input-md" {{$required}}  type="number">
       </div>
   </div>
   @endif
   @if($field->type == "date" )
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <div class="col-sm-8">
           <input  name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif  class="form-control input-md" {{$required}}  type="text">
       </div>
   </div>
   @endif
   @if($field->type == "datetime")
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <div class="col-sm-8">
           <input name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif  class="form-control input-md" {{$required}}  type="text">
       </div>
   </div>
   @endif
   @if($field->type == "video" || $field->type == "url")
   <div class="form-group row">
       <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
       <div class="col-sm-8">
           <input  name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif   class="form-control input-md" {{$required}}  type="text">
       </div>
   </div>
   @endif

   

   @endforeach

@endif