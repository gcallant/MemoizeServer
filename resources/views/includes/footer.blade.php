
<link rel="stylesheet" type="text/css" href="{{asset('css/footer.css')}}">
{{--
Thank you to tutorialzine for their footer template
@see https://tutorialzine.com/2015/01/freebie-5-responsive-footer-templates
--}}
<link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">

<footer class="footer-distributed">

    <div class="footer-left">

        <h3>Memo<span>ize</span></h3>

        <p class="footer-links">
            <a href="home">Home</a>
            &centerdot;
            <a href="blog">Blog</a>
            &centerdot;
            <a href="pricing">Pricing</a>
            &centerdot;
            <a href="about">About</a>
            &centerdot;
            <a href="faq">Faq</a>
            &centerdot;
            <a href="contact">Contact</a>
        </p>

        <p class="footer-company-name"><a href="https://grantcallant.com">Grant Callant &copy; {{Date('Y')}}</a></p>
    </div>

    <div class="footer-center">

        <div>
            <i class="fa fa-map-marker"></i>
            <p><span>Eastern Washington University</span> Cheney, Washington</p>
        </div>

        <div>
            <i class="fa fa-phone"></i>
            <p>+1 971 333 8959</p>
        </div>

        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="mailto:grant@grantcallant.com">grant@grantcallant.com</a></p>
        </div>

    </div>

    <div class="footer-right">

        <p class="footer-company-about">
            <span>About {{config("app.name")}}</span>
            I decided to make this application so passwords would be a thing of the past. If you have any problems, questions, or comments you can shoot me an email.
        </p>

        <div class="footer-icons">

            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="https://github.com/gcallant/{{config("app.name")}}"><i class="fa fa-github"></i></a>

        </div>

    </div>

</footer>
