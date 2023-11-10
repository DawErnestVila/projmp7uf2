<main>
    <div class="container my-5">
        <?php
        if (isset($_SESSION['flash'])) {
        ?>
            <div class="alert alert-danger p-3 mx-auto my-3 text-center col-md-6 fw-bolder" role="alert">
                <?php echo $_SESSION['flash']; ?>
            </div>
        <?php
            unset($_SESSION['flash']);
        }

        ?>
        <div class="card mx-auto" style="width: 50%;">
            <div class="card-body text-center">
                <h1 class="card-title mt-5 mb-3">Dr0ive</h1>
                <p class="card-text my-4">El teu emmagatzematge al núvol preferit</p>
                <a class="btn btn-primary mb-5" href="/user/create">Registra't</a>
            </div>
        </div>
    </div>
</main>