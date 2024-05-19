<!doctype html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html ; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <title>Quản lý thông tin khách hàng</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
      .card1 {
        display: flex;
        height: 70px;
        width: 350px;
      }

      .card1 svg {
        position: absolute;
        display: flex;
        width: 60%;
        height: 100%;
        font-size: 24px;
        font-weight: 700;
        opacity: 1;
        transition: opacity 0.25s;
        z-index: 2;
        padding: 0.25rem;
        cursor: pointer;
      }

      .card1 .social-link1, .card1 .social-link2, .card1 .social-link3, .card1 .social-link4, .card1 .social-link5 {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 25%;
        color: whitesmoke;
        font-size: 24px;
        text-decoration: none;
        transition: 0.25s;
        border-radius: 50px;
      }

      .card1 svg {
        transform: scale(1);
      }

      .card1 .social-link1:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f09433', endColorstr='#bc1888', GradientType=1);
        animation: bounce_613 0.4s linear;
      }

      .card1 .social-link2:hover {
        background-color: #242c34;
        animation: bounce_613 0.4s linear;
      }

      .card1 .social-link3:hover {
        background-color: #5865f2;
        animation: bounce_613 0.4s linear;
      }

      .card1 .social-link4:hover {
        background-color: #0a66c2;
        animation: bounce_613 0.4s linear;
      }

      .card1 .social-link5:hover {
        background-color: #ff8000;
        animation: bounce_613 0.4s linear;
      }

      @keyframes bounce_613 {
        40% {
          transform: scale(1.4);
        }
        60% {
          transform: scale(0.8);
        }
        80% {
          transform: scale(1.2);
        }
        100% {
          transform: scale(1);
        }
      }.subscribe {
  position: relative;
  height: 140px;
  width: 240px;
  padding: 20px;
  background-color: #FFF;
  border-radius: 4px;
  color: #333;
  box-shadow: 0px 0px 60px 5px rgba(0, 0, 0, 0.4);
}

.subscribe:after {
  position: absolute;
  content: "";
  right: -10px;
  bottom: 18px;
  width: 0;
  height: 0;
  border-left: 0px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #1a044e;
}

.subscribe p {
  text-align: center;
  font-size: 20px;
  font-weight: bold;
  letter-spacing: 4px;
  line-height: 28px;
}

.subscribe input {
  position: absolute;
  bottom: 30px;
  border: none;
  border-bottom: 1px solid #d4d4d4;
  padding: 10px;
  width: 82%;
  background: transparent;
  transition: all .25s ease;
}

.subscribe input:focus {
  outline: none;
  border-bottom: 1px solid #0d095e;
  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', 'sans-serif';
}

.subscribe .submit-btn {
  position: absolute;
  border-radius: 30px;
  border-bottom-right-radius: 0;
  border-top-right-radius: 0;
  background-color: #0f0092;
  color: #FFF;
  padding: 12px 25px;
  display: inline-block;
  font-size: 12px;
  font-weight: bold;
  letter-spacing: 5px;
  right: -10px;
  bottom: -20px;
  cursor: pointer;
  transition: all .25s ease;
  box-shadow: -5px 6px 20px 0px rgba(26, 26, 26, 0.4);
}

.subscribe .submit-btn:hover {
  background-color: #07013d;
  box-shadow: -5px 6px 20px 0px rgba(88, 88, 88, 0.569);
}


    </style>
  </head>
  <body>
    <div class="footer">
      <div class="footer" style="background-color: #1F1B24; color: white; border-radius: 10px; margin-top: 20px; height: 300px;">
        <div class="row">
          <div class="col" style="margin-left:30px"><br />
            <b>Chính sách</b><br /><br />
            Ưu đãi đối tác<br />
            Bảo vệ thông tin người dùng <br />
            Bảo mật giao dịch của khách hàng <br />
            Chính sách bảo hành <br />
          </div>
          <div class="col order-5"><br />
            <b>Thông tin khác</b><br /><br />
            Email: <span style="color:#98F5FF;">@hufi.edu.com</span><br />
            Điện thoại: <span style="color:#98F5FF;">0912345678</span><br />
          </div>
          
          <div class="col order-1"><br />
            <b>Hỗ trợ khách hàng</b><br /><br />
            Hướng dẫn mua hàng<br />
            Hóa đơn điện tử <br />
            Phương thức thanh toán<br />
            Vận chuyển và giao nhận<br /><br /><br />
          </div>
          
        </div>

        <div class="row" style="height: 50px;">
        <div class="col-3"></div>
            <div class="col-6" >
            <div class="card1"style="margin-left: auto; margin-right: auto;">
                <a class="social-link1" aria-label="Instagram">
                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.281.11-.705.24-1.485.276-.843.039-1.096.046-3.231.046-2.135 0-2.389-.007-3.231-.046-.78-.036-1.204-.166-1.485-.276a2.471 2.471 0 0 1-.92-.598 2.474 2.474 0 0 1-.598-.92c-.11-.281-.24-.705-.276-1.485-.039-.843-.046-1.096-.046-3.231s.007-2.389.046-3.231c.036-.78.167-1.204.276-1.485a2.47 2.47 0 0 1 .598-.92c.28-.28.546-.453.92-.598.282-.11.706-.24 1.485-.276.844-.04 1.097-.047 3.232-.047zM8 3.883a4.116 4.116 0 1 0 0 8.233 4.116 4.116 0 0 0 0-8.233zm0 6.774a2.657 2.657 0 1 1 0-5.315 2.657 2.657 0 0 1 0 5.315zm5.221-6.845a.96.96 0 1 1-1.92 0 .96.96 0 0 1 1.92 0z"/>
                </svg>
                </a>
                <a class="social-link2" aria-label="Github">
                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82a7.6 7.6 0 0 1 2-.27c.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.28.82 2.15 0 3.07-1.87 3.75-3.64 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                </svg>
                </a>
                <a class="social-link3" aria-label="Discord">
                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-discord" viewBox="0 0 16 16">
                    <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833-1.172-.176-2.34-.176-3.496 0-.11-.25-.27-.583-.406-.833a.051.051 0 0 0-.052-.025c-1.125.194-2.22.524-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.042-.213 9.045.066 12.016a.042.042 0 0 0 .017.028c1.372 1.01 2.7 1.63 4.006 2.034a.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011c-.893-.337-1.644-.75-2.396-1.255a.05.05 0 0 1-.007-.081c.162-.12.324-.24.485-.353a.05.05 0 0 1 .051 0c4.967 3.582 10.243 0 10.276-.003a.05.05 0 0 1 .052.003c.161.113.323.233.485.353a.05.05 0 0 1-.006.081 12.298 12.298 0 0 1-2.397 1.255.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019c1.307-.404 2.635-1.024 4.006-2.034a.052.052 0 0 0 .017-.028c.334-3.451-.559-6.449-2.366-9.091a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.612 1.438-1.612.807 0 1.45.73 1.438 1.612 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.437-.724-1.437-1.612 0-.889.636-1.612 1.437-1.612.808 0 1.45.73 1.438 1.612 0 .888-.63 1.612-1.438 1.612Z"/>
                </svg>
                </a>
                <a class="social-link4" aria-label="LinkedIn">
                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                    <path d="M0 1.146C0 .513.324 0 .725 0h14.55c.4 0 .725.513.725 1.146v13.708c0 .633-.324 1.146-.725 1.146H.725A.72.72 0 0 1 0 14.854V1.146zm4.943 12.248V6.169H3.156v7.225h1.787zM4.072 5.13c.621 0 1.005-.413 1.005-.928-.011-.526-.384-.928-.993-.928-.61 0-.992.402-1.005.928 0 .515.384.928.993.928h.007zm3.825 8.264V9.359c0-.205.015-.41.076-.558.167-.41.547-.834 1.186-.834.838 0 1.173.63 1.173 1.553v4.004h1.787V9.246c0-2.22-1.185-3.254-2.76-3.254-1.273 0-1.845.705-2.165 1.198h.015v-1.03H5.825c.023.66 0 7.225 0 7.225h1.787z"/>
                </svg>
                </a>
                <a class="social-link5" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stack-overflow" viewBox="0 0 16 16">
                    <path d="M12.412 14.572V10.29h1.428V16H1v-5.71h1.428v4.282z"/>
                    <path d="M3.857 13.145h7.137v-1.428H3.857zM10.254 0 9.108.852l4.26 5.727 1.146-.852zm-3.54 3.377 5.484 4.567.913-1.097L7.627 2.28l-.914 1.097zM4.922 6.55l6.47 3.013.603-1.294-6.47-3.013zm-.925 3.344 6.985 1.469.294-1.398-6.985-1.468z"/>
                    </svg>
                </a>
            </div>  
        </div><div class="col-3"></div>
        
  </div>
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
