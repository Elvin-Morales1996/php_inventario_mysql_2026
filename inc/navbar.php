<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./img/logo.png" width="50" height="60">
    </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

<!--aqui-->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Usuario
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=user_new">Nuevo</a>
                    <a class="navbar-item" href="index.php?vista=user_list">Lista</a>
                    <a class="navbar-item" href="index.php?vista=user_search">Buscar</a>

                </div>
            </div>

                        <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Categoria
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">nuevas categorias</a>
                    <a class="navbar-item">Lista de categoria</a>
                    <a class="navbar-item">Buscar categoria</a>
                 
                </div>
            </div>

                        <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Productos
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">Nuevo</a>
                    <a class="navbar-item">Lista</a>
                    <a class="navbar-item">por categorias</a>
                    <a class="navbar-item">Buscar</a>
                 
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" 
                    class="button is-primary is-rounded">
                        Mi cuenta
                    </a>
                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>