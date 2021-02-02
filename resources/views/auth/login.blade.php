@extends('layouts.app')

@section('content')
    <div style="margin:0;padding:0;display:inline;">
        <legend>
            Login to Memoize
        </legend>
        @if (Session::has('login_failed'))
            <ul class="notice errors">
                <li>{{ Session::get('login_failed') }}</li>
            </ul>
        @endif
        @if (Session::has('logout'))
            <ul class="notice success">
                <li>{{ Session::get('logout') }}</li>
            </ul>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="p-5 d-none" id="loginApprovalQueue">
                                {{--                                <div class="w-50 my-5 mx-auto mobilePhone">--}}
                                {{--                                    <img src="images/approval-mobile.svg" class="w-100">--}}
                                {{--                                </div>--}}
                                <h5 class="text-center text-primary">Scan the barcode using the Memoize app
                                    on your phone</h5>
                                <small class="d-block text-secondary text-center">
                                    To log in, open the Memoize app on one of your registered devices and
                                    scan the barcode
                                </small>
                                <div class="text-center mt-3">
                                    <div id="{{$random_id}}" class="qrcode">
                                        {!! QrCode::size(300)->generate($random_id); !!}
                                    </div>
                                    <img src="{{ asset('/images/spinner.svg') }}" alt="">
                                </div>
                            </div>
                        </div>


                        <div class="p-5" id="loginFormWrapper">
                            <form method="POST" action="" class="user" id="authenticationForm">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
{{--<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>--}}
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
{{--<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>--}}
<script type="text/javascript">
    const showApprovalAndListenForApproval = callback => {
        $('#loginFormWrapper').addClass('d-none');
        $('#loginApprovalQueue').removeClass('d-none');

        Echo.channel('auth-request')
            .listen('.approval-granted', e => getTokenAndRedirectToHome());
    };

    $(document).ready(() => {
        $('#authenticationForm').on('submit', e => {
            e.preventDefault();

            // showApprovalAndListenForApproval($randomID => {
            //     alert(document.getElementsByClassName('qrcode').toString());
            //     axios.post('login/confirm', document.getElementsByClassName('qrcode').toString())
            //         .then(response => localStorage.setItem('memoizeToken', response.data.access_token))
            //         .then(() => location = axios.get(''))
            //         .catch(e => alert(e));
            // });
            showApprovalAndListenForApproval();
        })
    })

    async function getTokenAndRedirectToHome() {
        // alert(document.getElementsByClassName('qrcode').toString());
        // await axios.post('login/confirm', document.getElementsByClassName('qrcode').toString())
        //     .then(response => localStorage.setItem('memoizeToken', response.data.access_token))
        try {
            location = (await axios.get('/home'));
        } catch (error) {
            console.log(error);
        }
            // .then(() => axios.get('home', {
            //     headers: {
            //         'Authorization': 'Bearer ' + localStorage.getItem('memoizeToken')
            //     }
            // }))
            // .catch(e => alert(e));
    }
</script>
