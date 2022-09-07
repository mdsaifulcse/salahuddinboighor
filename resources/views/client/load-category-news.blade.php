@if(count($categoryNews)>0)

    @foreach($categoryNews as $news)

        <?php
        if (isset($news->newsSubCategory))
        {
            $url=$news->newsCategory->link.'/'.$news->newsSubCategory->link.'/'.$news->id.'/'.$news->title;
        }else{
            $url=$news->newsCategory->link.'/'.'news'.'/'.$news->id.'/'.$news->title;
        }

        ?>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="single-block cat-block">
                <div class="row">
                    <div class="col-xs-5 col-sm-5">
                        <div class="img-box">
                            <a href="{{url($url)}}" title="{{$news->title}}">
                                <img alt="{{$news->title}}" src="{{asset($news->feature_medium)}}" data-src="{{asset($news->feature_medium)}}" class="lazyload img-responsive">
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-7 col-sm-7">
                        <div class="paddingTop10 paddingRight10">
                            <h3 style="font-size:1.1em;"><a href="{{url($url)}}" title="{{$news->title}}"> {{$news->title}}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endforeach

    {{--<div class="text-center paddingBottom20">--}}
        {{--@if($categoryNews->nextPageUrl()!='')--}}
        {{--<button id="load_more_button" data-link="{{$categoryNews->nextPageUrl()}}">--}}
            {{--আরও পড়ুন 1</button>--}}
            {{--@endif--}}
    {{--</div>--}}

@else
    <h4 class="text-danger text-center">কোন ফলাফল পাওয়া যায়নি</h4>
@endif