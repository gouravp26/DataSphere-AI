<?php

if (isset($_SESSION['success'])):

?>

<div class="alert alert-success alert-dismissible fade show" role="alert">

    <?= htmlspecialchars($_SESSION['success']) ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert">
    </button>

</div>

<?php

unset($_SESSION['success']);

endif;

?>

<?php

if (isset($_SESSION['error'])):

?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <?= htmlspecialchars($_SESSION['error']) ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert">
    </button>

</div>

<?php

unset($_SESSION['error']);

endif;

?>

<?php

if (isset($_SESSION['warning'])):

?>

<div class="alert alert-warning alert-dismissible fade show" role="alert">

    <?= htmlspecialchars($_SESSION['warning']) ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert">
    </button>

</div>

<?php

unset($_SESSION['warning']);

endif;

?>

<?php

if (isset($_SESSION['info'])):

?>

<div class="alert alert-info alert-dismissible fade show" role="alert">

    <?= htmlspecialchars($_SESSION['info']) ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert">
    </button>

</div>

<?php

unset($_SESSION['info']);

endif;

?>

<script>
const alerts = document.querySelectorAll('.alert');

if (alerts.length > 0) {

    setTimeout(() => {

        alerts.forEach(alert => {
            bootstrap.Alert.getOrCreateInstance(alert).close();
        });

    }, 4000);

}
</script>