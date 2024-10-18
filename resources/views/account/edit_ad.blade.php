@extends('frontend.app')

@section('content')

<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script type="text/javascript">

$(function(){
    var $ckfield = CKEDITOR.replace( 'description' );

    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});

   

 
</script>

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                   
               <form class="form-horizontal" method="POST" action="{{route('updateProfile')}}" role="form" id="postAnAd">
                   @csrf
                    <div class="inner-box">
                        <div class="welcome-msg">
                            <h3 class="page-sub-header2 clearfix no-padding">{{ trans('account.edit_ad.update_ad') }}</h3>
                            <span class="page-sub-header-sub small"><strong>{{ trans('account.edit_ad.updating') }}</strong> {{$post->title}}</span>
                        </div>
                        <div id="accordion" class="panel-group">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB1" aria-expanded="true"  data-bs-toggle="collapse" > 
                                    {{ trans('account.edit_ad.ad_details') }}</a></h4>
                                </div>
                                <div class="panel-collapse collapse show" id="collapseB1">
                                    <div class="card-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ad.name') }}</label>
                                                <div class="col-sm-9">
                                                <input type="hidden" value="{{$post->id}}" name="post_id" id="post_id">
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="">{{ trans('account.edit_ad.select _category') }}</option>
                                                    @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}" @if($cat->id == $post->category_id) selected @endif>{{$cat->name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ad.title') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="title" value="{{$post->title}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ad.description') }} </label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="description" name="description">{{$post->description}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ad.price') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="price" value="{{$post->price}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                 <label class="col-sm-2 control-label"> {{trans('Select Purpose') }}</label>
                                                <div class="col-sm-8">
                                                    <label class="form-check form-check-inline l">
                                                        <label class="form-check-label mb-0 pb-0">
                                                            <input class="form-check-input" type="radio" @if($post->type == "sell") checked @endif name="type" id="inlineRadio1" value="sell">{{trans('Sell') }}
                                                        </label>
                                                    </label>
                                                    <label class="form-check form-check-inline l">
                                                        <label class="form-check-label mb-0 pb-0">
                                                            <input class="form-check-input" type="radio" @if($post->type == "rent") checked @endif  name="type" id="inlineRadio2" value="rent">{{trans('Rent') }}
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>
                                   
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">{{trans('ads.post_ad.condition') }}</label>
                                                <div class="col-sm-8">
                                                    <label class="form-check form-check-inline l">
                                                        <label class="form-check-label mb-0 pb-0">
                                                            <input class="form-check-input" type="radio" @if($post->condition == "new") checked @endif  name="condition" id="inlineRadio1" value="new">{{trans('ads.post_ad.new') }}
                                                        </label>
                                                    </label>
                                                    <label class="form-check form-check-inline l">
                                                        <label class="form-check-label mb-0 pb-0">
                                                            <input class="form-check-input" type="radio" @if($post->condition == "used") checked @endif  name="condition" id="inlineRadio2" value="used">{{trans('ads.post_ad.used') }}
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">{{ trans('account.edit_ad.city') }}</label>
                                                <div class="col-sm-9">
                                                <select id="seller-city" name="city_id" class="select2 form-control">
                                                    @foreach($cities as $city)
                                                        <option @if($city->id == $post->city_id) selected @endif  value="{{$city->id}}" >{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col-sm-2 control-label" for="seller-area">{{trans('ads.post_ad.city_area') }}</label>
                                                <div class="col-sm-8">
                                                    <select id="seller-area"  name="area_id" class="select2 form-control">
                                                    
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title"><a href="#collapseB2" aria-expanded="true"  data-bs-toggle="collapse" >{{ trans('account.edit_ad.aditional_information') }} </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseB2">
                                        <div class="card-body" id="customFields">

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card card-default"> -->
                                    <!-- <div class="card-header">
                                        <h4 class="card-title"><a href="#collapseB3" aria-expanded="true"  data-bs-toggle="collapse" >
                                            Preferences </a></h4>
                                    </div> -->
                                    <!-- <div class="panel-collapse collapse" id="collapseB3">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">
                                                            I want to receive newsletter. </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">
                                                            I want to receive advice on buying and selling. </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                            </div>
                            <!--/.row-box End-->
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" id="PostNow" class="btn btn-success">{{ trans('account.edit_ad.update') }}</button>
                                    <br><br>
                                    <div id="showError"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


    <script> 
    
    $(document).ready(function() {

    $(function() { 
       $("#seller-city").change();
     });
    

    $("body").on("change" , "#seller-city", function() { 
        var form_data = {
            city_id: $(this).val()
        }
        $.ajax({
            url: "{{ route('ad-city-areas') }}",
            type: 'POST',
            data: form_data,
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            beforeSend: function () {
                $(".blockUI").show();
            },
            complete: function () {
                $(".blockUI").hide();
            },
            success: function(html) {
                $("#seller-area").html(html);
            }
        });
    });

    
            $('#postAnAd').submit(function() {
            var form_data = $(this).serialize();

            $.ajax({
                url: "{{ route('update-ad') }}",
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".blockUI").show();
                    $("#PostNow").text("Updating...");
                },
                complete: function () {
                    $(".blockUI").hide();
                },
                success: function(result) {
                    // var obj = JSON.parse(result);
                    var err = "";
                    if(result == "success") { 
                        err += '<div class="alert alert-success" role="alert">';
                        err += "Updated Successfully";
                        err += '</div>';
                    }
                    if(result == "failed") { 
                        err += '<div class="alert alert-danger" role="alert">';
                        err += "Failed to update";
                        err += '</div>';
                    }

                    
                    $("#PostNow").text("Update");
                    $("#showError").html(err);

                    
                   
                },
                error: function(result) { 
                     var obj = JSON.parse(result);
                    console.log(result);
                }
            });
            return false;
        });



        setTimeout(() => {
            $("#category_id").change();
        }, 1000);
        
        $("body").on("change", "#category_id", function() { 
            var form_data = {
                id: $("#category_id").val(),
                post_id: <?php echo $post->id; ?>
            }
            $.ajax({
                url: "{{ route('get-additional-fields') }}",
                type: 'POST',
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                },
                beforeSend: function () {
                    $(".blockUI").show();
                },
                complete: function () {
                    $(".blockUI").hide();
                },
                success: function(html) {
                    $("#customFields").html(html);
                }
            });
        });

        $('#profileForm, #userPassword').submit(function(e) {
            e.preventDefault(); // Prevent form submission
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // Handle the success response
                    if(response == "success") {
                        $("#success").show();
                        $("#failed").hide();
                    } else { 
                        $("#success").hide();
                        $("#failed").show();
                    }
                   
                    setTimeout(function() { 
                        $("#successMsg").hide();
                    } , 1000)
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>


@endsection
