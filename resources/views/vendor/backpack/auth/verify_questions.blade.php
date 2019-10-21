@extends('backpack::layout_guest')

@section('content')
    <div class="row" style="padding-top: 50px">
        <div class="col-md-6" id="verify_img">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" style="background: #000000" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="2" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="3" style="background: #000000" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="4" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="5" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="6" style="background: #000000" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="7" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="8" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="9" style="background: #000000" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="10" style="background: #000000"></li>
                    <li data-target="#myCarousel" data-slide-to="11" style="background: #000000"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" style="border-radius: 5px">
                    <div class="item active">
                        <img src="/images/slide_introduce/Slide1.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide2.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide3.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide4.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide5.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide6.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide7.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide8.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide9.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide10.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide11.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                    <div class="item">
                        <img src="/images/slide_introduce/Slide12.GIF" alt="Los Angeles" style="width:100%;">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="color: #000000">
                    <span class="glyphicon glyphicon-chevron-left" style="top: 90%;"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next" style="color: #000000">
                    <span class="glyphicon glyphicon-chevron-right" style="top: 90%;"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <!--CSS list style with number cicles background -->
            <div class="numberlist">
                @php
                    $confirm = end($questions);
                    $first = $questions[0];
                    array_pop($questions);
                    array_shift($questions);
                @endphp
                <h1 style="text-align: center; margin: 0; padding-top: 10px">Letter of Undertaking</h1>
                <h4 style="padding-left: 10px">{{ $first }}</h4>
                <ol style="padding: 10px;overflow-y: scroll; height:300px;">

                    @foreach($questions as $question)
                        <li class="verify_question_li"><input type="checkbox" class="verify_question" style="display: none"><span>{!! $question !!}</span></li>
                    @endforeach
                </ol>
                <div>
                    <form class="p-t-10 p-b-10 p-r-10 p-l-10 fromLogin" id="verify_form" style="" role="form" method="POST" action="{{ route('backpack.auth.verify.questions') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('verify_questions_value') ? ' has-error' : '' }}">
                            <input type="hidden" value="{{ $token }}" name="token">
                            <input type="checkbox" class="form-check-input" name="verify_questions_value" value="1">
                            <label class="control-label">{{ $confirm ?? 'I agree to follow the rules' }}</label>
                            @if ($errors->has('verify_questions_value'))
                                <span class="help-block">
                                <strong>{{ $errors->first('verify_questions_value') }}</strong>
                            </span>
                            @endif
                            <button type="submit" class="btn btn-block btn-primary grad-red">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--<form style="background: #ffffff">--}}
        {{--<--}}
    {{--</form>--}}
@endsection

@section('after_scripts')
    <script>
        $(function () {
            $(`input[type='checkbox']`).prop('checked', false);
            // $(document).on('click', `input[name='verify_questions_value']`, function (e) {
            //     let aggree = $(this);
            //     if ($(this).is(':checked')) {
            //         $(`.verify_question`).each(function (index) {
            //             if (!$(this).is(':checked')) {
            //                 alert('You must undertake all above clauses!');
            //                 aggree.prop('checked', false);
            //                 return false;
            //             }
            //         })
            //     }
            // });
            $("#verify_form").submit(function(e) {
                if (!$(`input[name='verify_questions_value']`).is(':checked')) {
                    alert('You must undertake all above clauses!');
                    e.preventDefault(e);
                }
            });
            //Initilize start value to 1 'For Slide1.GIF'
            let currentIndex = 1;
            //NOTE: Set this value to the number of slides you have in the presentation.
            let maxIndex=12;
            function swapImage(imageIndex){
                //Check if we are at the last image already, return if we are.
                if(imageIndex>maxIndex){
                    currentIndex=maxIndex;
                    return;
                }
                //Check if we are at the first image already, return if we are.
                if(imageIndex<1){
                    currentIndex=1;
                    return;
                }
                currentIndex=imageIndex;
                //Otherwise update mainImage
                document.getElementById("mainImage").src='Slide' +  currentIndex  + '.GIF';
                return 0;
            }
        })
    </script>
@endsection
@section('after_styles')
    <style>
        /* css list with numeber circle background -------------- */
        .numberlist{
            width: 90%;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            height: 500px;
            -webkit-box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
            -moz-box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
            box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
        }
        .numberlist ol{
            counter-reset: li;
            list-style: none;
            font: 15px 'trebuchet MS', 'lucida sans';
            padding: 0;
        }
        .numberlist ol ol{
            margin: 0 0 0 2em;
        }

        .numberlist span{
            position: relative;
            display: inline-block;
            padding: .4em .4em .4em 2em;
            width: 80%;
            margin: .5em 0;
            color: #000000;
            text-decoration: none;
            -moz-border-radius: .3em;
            -webkit-border-radius: .3em;
            border-radius: .3em;
        }
        .numberlist li {
            position: relative;
            padding-left: 20px;
            background: rgba(237, 237, 237, 0.6);
            margin: 5px;
            border-radius: 5px;
        }
        .numberlist li ol {
            list-style: upper-roman;
        }
        .numberlist input {
            position: absolute;
            top: 40%;
            left: 10px;
            transform: scale(1.5);
        }
        #verify_form {
            color: #000000;
            height: 100px;
            background: rgba(237, 237, 237, 0.6);
            border-radius: 5px;
        }
        #verify_form div.form-group{
            padding-left: 25px;
            position: relative;
        }
        #verify_form div.form-group input[type='checkbox'] {
            position: absolute;
            top: 15%;
            left: 0;
        }
        #verify_img {
            position: relative;
            border-radius: 5px;
            height: 500px;
        }

        #verify_img #myCarousel {
            position: absolute;
            left: 6%;
            border-radius: 5px;
            width: 90%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            -webkit-box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
            -moz-box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
            box-shadow: -1px 3px 16px 5px rgba(0,0,0,0.75);
        }
        /* End css list with numeber circle background -------------- */
    </style>
@endsection
