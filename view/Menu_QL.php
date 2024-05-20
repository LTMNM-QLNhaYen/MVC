
<!doctype html PUBLIC "-//W3C//DTD HMTL 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html ; charset=utf-8" http-equiv="Content-Type" >
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Quản lý thông tin khách hàng</title>
    <link rel="stylesheet" type="text/css" href="style.css">


    <style>
        #navbody {
  width: 300px;
  height: 60px;
  background-color: #1F1B24;
  border-radius: 40px;
  box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.041);
  align-items: center;
  justify-content: center;
  display: flex;
}

.ul {
  list-style: none;
  width: 100%;
  background-color: transparent;
  display: flex;
  justify-content: space-between;
  margin-top: 5px;
}

.ul .li {
  display: inline-block;
}

.radio {
  display: none;
}

.svg {
  width: 70px;
  height: 70px;
  opacity: 80%;
  cursor: pointer;
  padding: 13px 20px;
  transition: 0.2s;
}

.ul .li .svg:hover {
  transition: 0.1s;
  color:#33CCFF;
  position: relative;
  margin-top: -4px;
  opacity: 100%;
}

.radio:checked + label .li .svg {
  color: #33CCFF;
  fill-rule: evenodd;
}

    </style>
  </head>
  <body>
  <div class="row" >
    <div class="col-12">

    <nav class="navbar navbar-expand-lg" style="background-color: #1F1B24; color: white; border-radius: 10px"    >

    <div class="container-fluid">
      <a class="navbar-brand" style=" color: white;margin-left:30px" href="#"><b>NhaYen</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav" >
        <ul class="navbar-nav"  style="margin-left: auto; margin-right: auto;">
        <div id="navbody">
            <form action="#">
                <ul class="ul">
                <input checked="" name="rad" class="radio" id="choose1" type="radio" />
                <label for="choose1">
                    <li class="li">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        height="24"
                        width="24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        class="svg w-6 h-6 text-gray-800 dark:text-white"
                    >
                        <path
                        d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="round"
                        stroke="currentColor"
                        ></path>
                    </svg>
                    </li>
                </label>
               
                <input class="radio" name="rad" id="choose3" type="radio" />
                <label for="choose3">
                    <li class="li">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        height="24"
                        width="24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        class="svg w-6 h-6 text-gray-800 dark:text-white"
                    >
                        <path
                        d="m17 21-5-4-5 4V3.889a.92.92 0 0 1 .244-.629.808.808 0 0 1 .59-.26h8.333a.81.81 0 0 1 .589.26.92.92 0 0 1 .244.63V21Z"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="round"
                        stroke="currentColor"
                        ></path>
                    </svg>
                    </li>
                </label>
                <input class="radio" name="rad" id="choose4" type="radio" />
                <label for="choose4">
                    <li class="li">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        height="24"
                        width="24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        class="svg w-6 h-6 text-gray-800 dark:text-white"
                    >
                        <path
                        d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="square"
                        stroke="currentColor"
                        ></path>
                    </svg>
                    </li>
                </label>
                </ul>
            </form>
            </div>

            </div>
            </div>
       
       
      </ul>

      
    </div>
  </div>
</nav>


    </div>
    
  </div>   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>