<style>
    .bg-verd {
        background-color: #00b159;
    }

    .bg-blau-clar {
        background-color: #7fdff5;
    }

    .bg-vermell-clar {
        background-color: #ff6961;
    }

    .bg-groc {
        background-color: #ffd700;
    }

    .bg-taronja {
        background-color: #ff8c00;
    }

    .bg-lila-clar {
        background-color: #b19cd9;
    }

    .bg-blau-fosc {
        background-color: #001f3f;
        color: white;
    }

    .bg-gris-clar {
        background-color: #f5d5d5;
    }

    .bg-vermell {
        background-color: #f9392c;
    }

    .bg-verd-fosc {
        background-color: #006400;
        color: white;
    }

    .bg-violeta {
        background-color: #8a2be2;
        color: white;
    }
</style>
<div class="container">
    <h1>Logs</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Data i hora</th>
                <th scope="col">Missatge</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parameters['logs'] as $log) : ?>
                <tr class="fw-bold bg-<? echo $log['color'] ?>">
                    <td><? echo $log['time'] ?></td>
                    <td><? echo $log['message'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>