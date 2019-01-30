@extends('backpack::layout_guest')

@section('content')
    <div class="row" style="padding-top: 50px">
        <div class="col-md-6" style="padding: 10px">
            <div style="width: 100%; text-align: center">
                <iframe style="margin: 0 auto; width: 90%; height: 460px"
                        src="https://www.youtube.com/embed/iUbZvwGqrUo?autoplay=1">
                </iframe>
            </div>
        </div>
        <div class="col-md-6">
            <!--CSS list style with number cicles background -->
            <h2 style="margin: 0"><strong>Question</strong></h2>
            <div class="numberlist">
                <ol>
                    <li><span>Question 1</span></li>
                    <li><span>Question 2</span></li>
                    <li><span>Question 3</span></li>
                    <li><span>Question 4</span></li>
                    <li><span>Question 5</span></li>
                    <li><span>Question 6</span></li>
                    <li><span>Question 7</span></li>
                    <li><span>Question 8</span></li>
                    <li><span>Question 9</span></li>
                    <li><span>Question 10</span></li>
                    <li>
                        <form class="p-t-10 p-b-10 p-r-10 p-l-10 fromLogin " style="background: rgba(0, 0, 0, 0.5);" role="form" method="POST" action="{{ route('backpack.auth.verify.questions') }}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('verify_questions_value') ? ' has-error' : '' }}">
                                <input type="hidden" value="{{ $token }}" name="token">
                                <input type="checkbox" class="form-check-input" name="verify_questions_value" value="1">
                                <label class="control-label" style="color: #ffffff">I agree to follow the rules</label>
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
                    </li>
                </ol>
            </div>


        </div>
    </div>

    {{--<form style="background: #ffffff">--}}
        {{--<--}}
    {{--</form>--}}
@endsection

@section('after_scripts')
    <style>
        /* css list with numeber circle background -------------- */
        .numberlist{
            width:450px;
        }
        .numberlist ol{
            counter-reset: li;
            list-style: none;
            *list-style: decimal;
            font: 15px 'trebuchet MS', 'lucida sans';
            padding: 0;
            margin-bottom: 4em;

        }
        .numberlist ol ol{
            margin: 0 0 0 2em;
        }

        .numberlist span{
            position: relative;
            display: block;
            padding: .4em .4em .4em 2em;
            *padding: .4em;
            margin: .5em 0;
            background: rgba(0, 0, 0, 0.55);
            color: #fff;
            text-decoration: none;
            -moz-border-radius: .3em;
            -webkit-border-radius: .3em;
            border-radius: .3em;
        }

        .numberlist span:hover{
            background: #000000;
        }

        /* End css list with numeber circle background -------------- */
    </style>
@endsection
