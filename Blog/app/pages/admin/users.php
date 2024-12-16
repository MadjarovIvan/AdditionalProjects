<?php if($action == 'add'):?>
    <div class="col-md-6 mx-auto">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Create Account</h1>

            <?php if (!empty($errors)) :?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif ?>

            <div class="form-floating">
                <input value="<?= old_value('username')?>" name="username" type="text" class="form-control" id="username" placeholder="Username">
                <label for="username">Username</label>
            </div>
            <?php if (!empty($errors['username'])) :?>
                <div class="text-danger"><?= $errors['username'] ?></div>
            <?php endif ?>
            <div class="form-floating">
                <input value="<?= old_value('email')?>" name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email</label>
            </div>
            <?php if (!empty($errors['email'])) :?>
                <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif ?>

            <div class="form-floating">
                <input value="<?= old_value('password')?>" name="password" type="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <?php if (!empty($errors['password'])) :?>
                <div class="text-danger"><?= $errors['password'] ?></div>
            <?php endif ?>
            <div class="form-floating">
                <input value="<?= old_value('retype_password')?>" name="retype_password" type="password" class="form-control" id="retype_password" placeholder="Retype Password">
                <label for="floatingPassword">Retype Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
        </form>
    </div>
<?php elseif($action == 'edit'):?>
    <div class="col-md-6 mx-auto">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Edit Account</h1>
            <?php if (!empty($row)):?>

                <?php if (!empty($errors)) :?>
                    <div class="alert alert-danger">Please fix the errors below</div>
                <?php endif ?>

                <div class="my-2">
                    <label for="image" class="w-100">
                        <img src="<?=get_image($row['image'])?>" alt="" class="mx-auto d-block image-preview-edit" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer">
                        <input onchange="display_image_edit(this.files[0])" type="file" name="image" id="image" class="form-control d-none">
                    </label>

                    <script>
                        function display_image_edit(file){
                            document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
                        }
                    </script>
                </div>

                <div class="form-floating">
                    <input value="<?= old_value('username', $row['username'])?>" name="username" type="text" class="form-control" id="username" placeholder="Username">
                    <label for="username">Username</label>
                </div>
                <?php if (!empty($errors['username'])) :?>
                    <div class="text-danger"><?= $errors['username'] ?></div>
                <?php endif ?>
                <div class="form-floating">
                    <input value="<?= old_value('email', $row['email'])?>" name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div>
                <?php if (!empty($errors['email'])) :?>
                    <div class="text-danger"><?= $errors['email'] ?></div>
                <?php endif ?>
                <p class="mt-3">Leave empty to keep old password</p>
                <div class="form-floating">
                    <input name="password" type="password" class="form-control" id="password" placeholder="Leave Empty to keep password">
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($errors['password'])) :?>
                    <div class="text-danger"><?= $errors['password'] ?></div>
                <?php endif ?>
                <div class="form-floating">
                    <input name="retype_password" type="password" class="form-control" id="retype_password" placeholder="Leave Empty to keep password">
                    <label for="floatingPassword">Retype Password</label>
                </div>
                <a href="<?=ROOT?>/admin/users">
                    <button class="btn btn-primary btn-lg py-2" type="button">Back</button>
                </a>
                <button class="btn btn-primary btn-lg py-2" type="submit">Save Changes</button>

            <?php endif ?>

        </form>
    </div>
<?php elseif($action == 'delete'):?>
    <div class="col-md-6 mx-auto">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Delete Account</h1>
            <?php if (!empty($row)):?>

                <?php if (!empty($errors)) :?>
                    <div class="alert alert-danger">Please fix the errors below</div>
                <?php endif ?>

                <div class="mb-3">
                    <div class="form-control"><?= old_value('username', $row['username'])?></div>
                </div>
                <?php if (!empty($errors['username'])) :?>
                    <div class="text-danger"><?= $errors['username'] ?></div>
                <?php endif ?>
                <div class="mb-3">
                    <div class="form-control"><?= old_value('email', $row['email'])?></div>
                </div>
                <?php if (!empty($errors['email'])) :?>
                    <div class="text-danger"><?= $errors['email'] ?></div>
                <?php endif ?>
                <a href="<?=ROOT?>/admin/users">
                    <button class="btn btn-primary btn-lg py-2" type="button">Back</button>
                </a>
                <button class="btn btn-danger btn-lg py-2" type="submit">Delete</button>

            <?php endif ?>

        </form>
    </div>
<?php  else:?>

    <h4>Users </h4>
    <a href="<?=ROOT?>/admin/users/add">
        <button class="btn btn-primary">Create User</button>
    </a>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Image</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php 
            
            $query = "SELECT * FROM users order by id desc";
            $rows = query($query);
            
            ?>

            <?php if(!empty($rows)):?>
                <?php foreach($rows as $row):?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=esc($row['username'])?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['role']?></td>
                        <td>
                            <img src="<?=get_image($row['image'])?>" alt="" style="width: 100px; height: 100px; object-fit: cover">
                        </td>
                        <td><?=date("jS M,Y",strtotime($row['date']))?></td>
                        <td>
                            <a href="<?=ROOT?>/admin/users/edit/<?=$row['id']?>">
                                <button class="btn btn-warning text-white btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            </a>
                            <a href="<?=ROOT?>/admin/users/delete/<?=$row['id']?>">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </table>
    </div>
<?php endif;?>
