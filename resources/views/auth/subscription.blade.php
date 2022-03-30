<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <link href="{{asset('contents/admin')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <title>Subscription</title>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>
            /*.wrapper-page { 
              height: 100vh;
              position: relative;
            }

            .center {
              margin: 0;
              position: absolute;
              top: 50%;
              left: 50%;
              -ms-transform: 
              translate(-50%, -50%);
              transform: translate(-50%, -50%);
            } */
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            a {
                text-decoration: none;
                color: #333;
            }

            a:hover {
                text-decoration: none;
                color: #888;
            }

        </style>
        
    </head>
    <body>

        <div class="container">
            <div class="text-right">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="waves-effect"><i class="fa fa-power-off"></i><span> Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <div class="wrapper-page flex-center position-ref full-height">
            <div class="ex-page-content text-center">
                <h3>Subscription Plan is over</h3>
                <div class="card-body">
                    <h5 class="card-title">
                        Please Contact BeatBugs IT <a href="callto:+8801872128260"><strong>+8801872128260</strong></a>  to Extend Your Subscription Plan.
                    </h5>
                    <a href="JavaScript:Void(0)" class="btn btn-primary">Contact</a>
                </div>
            </div>
        </div>
	</body>
</html>