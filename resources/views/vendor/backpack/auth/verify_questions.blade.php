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
            <div class="numberlist">
                @php
                    $confirm = end($questions);
                    $first = $questions[0];
                    array_pop($questions);
                    array_shift($questions);
                @endphp
                <h1 style="text-align: center">Letter of Undertaking</h1>
                <h4 style="padding-left: 10px">{{ $first }}</h4>
                <ol style="padding: 10px;overflow-y: scroll; height:400px;">

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
        })
    </script>
@endsection
@section('after_styles')
    <style>
        /* css list with numeber circle background -------------- */
        .numberlist{
            width:600px;
            background: #fff;
            border-radius: 5px;
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
            background: #ededed;
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
            background: #ffffff ;
            color: #000000;
            height: 100px;
            border-radius: 5px;
            -webkit-box-shadow: 0px 4px 19px 5px rgba(0,0,0,0.52);
            -moz-box-shadow: 0px 4px 19px 5px rgba(0,0,0,0.52);
            box-shadow: 0px 4px 19px 5px rgba(0,0,0,0.52);
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
        /* End css list with numeber circle background -------------- */
    </style>
@endsection
