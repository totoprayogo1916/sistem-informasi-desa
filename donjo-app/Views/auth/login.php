<?= $this->extend("template/main") ?>

<?= $this->section("content") ?>

<main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Selamat datang!</h1>
                    <p class="text-lead text-white">Masuk sekarang untuk mengatur sistem</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0 shadow-sm">
                    <div class="card-body">
                        <form role="form" action="<?= site_url("siteman") ?>" method="post">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Pengguna" aria-label="Pengguna">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Kata sandi" aria-label="Kata sandi">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Masuk</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Lupa Kata sandi? <a href="javascript:;" class="text-dark font-weight-bolder">Atur ulang</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
