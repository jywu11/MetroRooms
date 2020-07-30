<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

?>
<style>
    body {
        padding: 0;
        margin: 0;
        font-family: "Oxygen", sans-serif;
    }

    .error-wall {
        width: 100%;
        height: 100%;
        position: fixed;
        text-align: center;
    }

    .error-wall.load-error {
        background-color: #f36c38;
    }

    .error-wall.load-error::after{
        background:url("http://ie.infotech.monash.edu/team107/team107-app/app//webroot/img/tem/houseoverlay.png");
        background-repeat: no-repeat;
        background-position: center;
        content: "";
        opacity: 0.05;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: absolute;
        z-index: -1;
    }
    .error-wall.matinence {
        background-color: #a473b1;
    }
    .error-wall.missing-page {
        background-color: #00bbc6;
    }
    .error-wall .error-container {
        display: block;
        width: 100%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
    }
    .error-wall .error-container h1 {
        color: #fff;
        font-size: 80px;
        margin: 0;
    }
    @media (max-width: 850px) {
        .error-wall .error-container h1 {
            font-size: 65px;
        }
    }
    .error-wall .error-container h3 {
        color: #464444;
        font-size: 34px;
        margin: 0;
    }
    @media (max-width: 850px) {
        .error-wall .error-container h3 {
            font-size: 25px;
        }
    }
    .error-wall .error-container h4 {
        margin: 0;
        color: #fff;
        font-size: 40px;
    }
    @media (max-width: 850px) {
        .error-wall .error-container h4 {
            font-size: 35px;
        }
    }
    .error-wall .error-container p {
        font-size: 15px;
    }
    .error-wall .error-container p:first-of-type {
        color: #464444;
        font-weight: lighter;
    }
    .error-wall .error-container p:nth-of-type(2) {
        color: #464444;
        font-weight: bold;
    }
    .error-wall .error-container p.type-white {
        color: #fff;
    }
    @media (max-width: 850px) {
        .error-wall .error-container p {
            font-size: 12px;
        }
    }
    @media (max-width: 390px) {
        .error-wall .error-container p {
            font-size: 10px;
        }
    }

</style>

<div class="error-wall load-error">
    <div class="error-container">
        <h1>oh no...</h1>
        <h3>We have had an error</h3>
        <h4>Error 400</h4>
        <h5>Bad Request Error</h5>
        <p>Sorry...please check back later or click <b><u> <?= $this->html->link('Home',['controller' => 'Properties' , 'action' => 'index']);?></u></b> to return to the homepage.</p>
        <p>If it is urgent please send us an email or give us a call<br> at NAIM's customer team at (03) 463-111-111.<br> Or email at support@NAIM.com</p>
    </div>
</div>

