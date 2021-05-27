<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url(); ?>asset/dist/img/<?= $user['foto']; ?>" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $user['username']; ?></h3>

                            <p class="text-muted text-center"><?= $user['nama']; ?></p>
                            <a href="#" class="btn btn-primary btn-block"><b>Edit</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Username</strong>

                            <p class="text-muted">
                                <?= $user['username']; ?>
                            </p>

                            <hr>

                            <strong><i class="fas fa-user mr-1"></i> Nama</strong>

                            <p class="text-muted"><?= $user['nama']; ?></p>

                            <hr>

                            <strong> <i class="fas fa-layer-group mr-1"></i> Level</strong>

                            <p class="text-muted"><?php if ($user['role'] == 1) {
                                                        echo 'admin';
                                                    } else {
                                                        echo 'Operator';
                                                    } ?></p>

                            <hr>

                            <strong><i class="fas fa-calendar-plus mr-1"></i> Tanggal Dibuat</strong>

                            <p class="text-muted"><?= date('d-m-Y', strtotime($user['date_created'])); ?></p>

                            <hr>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>