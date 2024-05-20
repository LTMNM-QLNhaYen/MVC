<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thống kê</title>
<style>
.card-container {
    display: flex;
    gap: 1rem; /* Khoảng cách giữa các thẻ */
}
.card {
    width: 190px;
    height: 124px;
    border-radius: 20px;
    background: #f5f5f5;
    position: relative;
    padding: 1.8rem;
    border: 2px solid #c3c6ce;
    transition: 0.5s ease-out;
    overflow: visible;
}

.card-details {
    color: black;
    height: 100%;
    gap: .5em;
    display: grid;
    place-content: center;
}

.card-button {
    transform: translate(-50%, 125%);
    width: 60%;
    border-radius: 1rem;
    border: none;
    background-color: #008bf8;
    color: #fff;
    font-size: 1rem;
    padding: .5rem 1rem;
    position: absolute;
    left: 50%;
    bottom: 0;
    opacity: 0;
    transition: 0.3s ease-out;
}

.text-body {
    color: rgb(134, 134, 134);
}

/* Text */
.text-title {
    font-size: 1.5em;
    font-weight: bold;
}

/* Hover */
.card:hover {
    border-color: #008bf8;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
}

.card:hover .card-button {
    transform: translate(-50%, 50%);
    opacity: 1;
}

	
</style>

</head>

<body>
<div class="card-container">
   <div class="row ">
    <div class="col">
        <div class="card">
            <div class="card-details">
                <p class="text-title">Card title</p>
                <p class="text-body">Here are the details of the card</p>
            </div>
            <button class="card-button">More info</button>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-details">
                <p class="text-title">Card title</p>
                <p class="text-body">Here are the details of the card</p>
            </div>
            <button class="card-button">More info</button>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-details">
                <p class="text-title">Card title</p>
                <p class="text-body">Here are the details of the card</p>
            </div>
            <button class="card-button">More info</button>
        </div>
    </div>
</div></div>




</body>
</html>