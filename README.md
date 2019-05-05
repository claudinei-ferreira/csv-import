# csv-import

Classe em PHP utilizada para fazer a leitura de dados que estão em um arquivo CSV. A classe faz apenas a leitura e trata os dados.
Caso necessite importar os dados para um banco será necessário implementar a estrutura para importar os dados para o Banco.

# Arquivo CSV com Dados para Importação: Exemplo
Crie um arquivo CSV com os dados ou gere a partir de uma Planilha do Excel, salvando-a no formato csv

```
Nome;Email;Profissao
Claudinei Ferreira de Jesus;claudinei.jesus@php.com;Programador PHP;
Maria Bonita;maria.bonita@javascript.com;Cangaceira do JavaScript;
```

# Formulário Para Importar os Dados: Exemplo
Crie um formulário com um campo Input File

```
<form name="import-csv" method="post" class="form-signin" enctype="multipart/form-data">
    <input type="hidden" name="action" value="import_data"/>
    <input type="file" name="file_csv" required/>
    <button class="btn btn-primary btn-block mt-5 mb-3" type="submit">Importar Dados</button>
</form>
```

# Importe os Dados com a Classe: ImportCSV
Obtenha os dados do formulário com o arquivo CSV

```
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
```
