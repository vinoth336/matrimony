@extends('public.app')
@section('content')
    <style>
        /* Import Google font - Poppins */

        :where(.phone_number_container, form, .input-field, header) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }

        .otp_form button {
            margin-top: 25px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            border: none;
            padding: 9px 0;
            cursor: pointer;
            border-radius: 6px;
            pointer-events: none;
            background: #6e93f7;
            transition: all 0.2s ease;
        }

        .otp_form button.active {
            background: #4070f4;
            pointer-events: auto;
        }

        .otp_form button:hover {
            background: #0e4bf1;
        }

        .hide {
            display: none;
        }
    </style>
    <div>
        @if(session()->get('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif


        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach


    </div>

    <div class="phone_number_container mt-5">
        <h4 class="text-center">
            Your Phone Number <b>{{ $member->phone_no }}</b> is need to verify. <br>
            OTP was sent to your registered phone, kindly check and
        enter OTP.</h4>
        <form action="{{ route('phone_number.verify') }}" onsubmit="return verifyOtp()" class="otp_form" method="post">
            @csrf
            <div class="input-field">
                <input type="number" class="otp_value"/>
                <input type="number" class="otp_value" disabled/>
                <input type="number" class="otp_value" disabled/>
                <input type="number" class="otp_value" disabled/>
            </div>
            <input type="hidden" name="otp" id="otp_input" />
            <button type="submit" onclick="verifyOTP()" id="generateBtn">Verify OTP</button>
        </form>
        <div id="errorMessage" class="error-message"></div>
        <div id="timer" class="timer"></div>
        <div class="hide" id="resend_otp">
            Didn't receive code?
            <form method="post" action="{{ route('phone_number.resend_otp') }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-success" id="resend_otp_button">
                    Resend OTP
                </button>
            </form>

        </div>

    </div>
    <script>
        const inputs = document.querySelectorAll("input"),
            button = document.querySelector("button");

        let timer;
        let secondOtpGenerateDuration = 3;
        let secondsRemaining = secondOtpGenerateDuration;

        $(document).ready(function () {
            startTimer();
        });

        // iterate over all inputs
        inputs.forEach((input, index1) => {
            input.addEventListener("keyup", (e) => {
                // This code gets the current input element and stores it in the currentInput variable
                // This code gets the next sibling element of the current input element and stores it in the nextInput variable
                // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
                const currentInput = input,
                    nextInput = input.nextElementSibling,
                    prevInput = input.previousElementSibling;

                // if the value has more than one character then clear it
                if (currentInput.value.length > 1) {
                    currentInput.value = "";
                    return;
                }
                // if the next input is disabled and the current value is not empty
                //  enable the next input and focus on it
                if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                // if the backspace key is pressed
                if (e.key === "Backspace") {
                    // iterate over all inputs again
                    inputs.forEach((input, index2) => {
                        // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                        // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                        if (index1 <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }
                //if the fourth input( which index number is 3) is not empty and has not disable attribute then
                //add active class if not then remove the active class.
                if (!inputs[3].disabled && inputs[3].value !== "") {
                    button.classList.add("active");
                    return;
                }
                button.classList.remove("active");
            });
        });

        const handlePaste = (e) => {
            e.preventDefault()
            const form = document.getElementById('otp_form')
            const inputs = [...form.querySelectorAll('.otp_value')]
            const text = e.clipboardData.getData('text')
            if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
                return
            }
            const digits = text.split('')
            inputs.forEach((input, index) => input.value = digits[index])
            submit.focus()
        }


        function startTimer() {
            timer = setInterval(function () {
                if (secondsRemaining >= 0) {
                    document.getElementById('timer').innerText =
                        `Time Remaining: ${secondsRemaining} seconds`;
                    secondsRemaining--;
                } else {
                    $("#resend_otp").removeClass('hide');
                    resetTimer();
                }
            }, 1000);
        }

        function resetTimer() {
            clearInterval(timer);
            document.getElementById('timer').innerText = '';
            secondsRemaining = secondOtpGenerateDuration;
        }

        //focus the first input which index is 0 on window load
        window.addEventListener("load", () => inputs[0].focus());

        function verifyOtp()
        {
            var otp = '';
            $(".otp_value").each(function() {
                otp += "" + $(this).val();
            });

            $("#otp_input").val(otp);

            return true;
        }
    </script>
@endsection
