<?php
include('../includes/header.php')
?>

<div class="col-md-5">
    <div class="jumbotron">
        <h1 class="display-3">Quienes somos?</h1>
        <p class="lead">Un Grupo de desarrollo web asi bien maquiavelicos pasados de lanza al estilo rambo</p>
        <hr class="my-2">
        <p>Mas info carnalo</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Contactanos</a>
        </p>
    </div>
</div>

<div class="col-md-7">
    <form>
    <div class = "form-group">
    <label for="exampleInputEmail1">Correo Electronio</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa tu correo">
    <small id="emailHelp" class="form-text text-muted">Asi sera facil saber quien eres</small>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Envianos un correo con tus ideas</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Tus ideas pueden cambiar al mundo?">
    </div>
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Quiero recbir infromacion via correo</label>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    
    
</div>

<?php
include('../includes/footer.php')
?>