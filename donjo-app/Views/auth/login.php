<?= $this->extend("template/main") ?>

<?= $this->section("content") ?>

<div id="loginform">
    <a href="<?= site_url() ?>first">
        <div id="facebook">
            <div id="sid">SID</div>
            <div id="connect">ver.</div>
            <div id="logo"><img src="<?= base_url() ?>assets/images/SID-e1351656852451.png"></div>
            <div id="desa">Desa <?= unpenetration($desa->nama_desa) ?></div>
            <div id="kec">Kecamatan <?= unpenetration(
                $desa->nama_kecamatan
            ) ?></div>
            <div id="kab">Kabupaten <?= unpenetration(
                $desa->nama_kabupaten
            ) ?></div>
        </div>
    </a>
    <div id="mainlogin">
        <div id="or"><?= VERSI_SID ?></div>
        <h1>Masukkan Username dan Password</h1>
        <form action="<?= site_url("siteman/auth") ?>" method="post">
            <input name="username" type="text" placeholder="username" value="" required>
            <input name="password" type="password" placeholder="password" value="" required>
            <button type="submit" id="but">LOGIN</button>
            <?php if (session("siteman") === -1) { ?>
                <div id="note">
                    Login Gagal. Username atau Password yang Anda masukkan salah!
                </div>
            <?php } elseif (session("siteman") === -2) { ?>
                <div id="note">
                    Tidak ada aktivitas dalam jangka waktu yang cukup lama. Demi keamanan silakan Login kembali.
                </div>
            <?php } ?>
        </form>
    </div>
    <div id="facebook2">
        <div id="kab2"><a href="http://combine.or.id" target="_blank"><img align=center src="<?= base_url() ?>assets/images/logo-combine.png"></a></div>
    </div>
</div>

<?= $this->endSection() ?>
