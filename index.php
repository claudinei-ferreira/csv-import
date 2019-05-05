<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Teste para Importação de Arquivo CSV</title>
</head>
<body>

    <main role="main">
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">Teste Importação de Dados de Arquivo CSV!</h1>
                <p>Para testar a importação de Dados de um arquivo CSV crie um arquivo no formato CSV com os dados devidamente estruturados e separados com "ponto e vígula (;)"</p>
            </div>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center">
                <form name="import-csv" method="post" class="form-signin" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="import_data"/>
                    <input type="file" name="file_csv" required/>
                    <button class="btn btn-primary btn-block mt-5 mb-3" type="submit">Importar Dados</button>
                </form>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 mt-4">
                      <?php
                      $postData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                      if($postData && $postData["action"] == "import_data"){
                          require_once "ImportCSV.php";

                          if (empty($_FILES['file_csv'])){
                              echo '<div class="alert alert-danger" role="alert"> Atenção! Envie um arquivo CSV </div>';
                              die;
                          }

                          if ($_FILES['file_csv']['type'] != 'application/vnd.ms-excel'){
                              echo '<div class="alert alert-danger" role="alert"> Atenção! O arquivo enviado parece não ser do tipo CSV </div>';
                              die;
                          }

                          $input_file = $_FILES['file_csv'];
                          $extension = pathinfo($_FILES['file_csv']['name']);
                          $remove_header = true;

                          $import = new ImportCSV();
                          $import->setInputFile($input_file, $remove_header);

                          // Validate return data
                          if($import->getResult()) {
                                $data_import = $import->getResult();
                                $count = 1;
                                ?>
                                <h2 class="text-center">Dados Importados do Arquivo Texto (CSV)</h2>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Profissão</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                          foreach ($data_import as $value) {
                                          ?>
                                              <tr>
                                                  <th scope="row"><?= $count; ?></th>
                                                  <td><?= $value[0]; ?></td>
                                                  <td><?= $value[1]; ?></td>
                                                  <td><?= $value[2]; ?></td>
                                              </tr>
                                          <?php
                                              $count++;
                                          }
                                          ?>
                                    </tbody>
                                </table>
                                <?php
                          }
                      }
                  ?>
                </div>
            </div>
        </div>
    </main>
    <footer class="container text-center mt-4"  >
        <p>Claudinei Ferreira de Jesus - Maio 2019 - V.1.0 </p>
    </footer>
</body>
</html>
