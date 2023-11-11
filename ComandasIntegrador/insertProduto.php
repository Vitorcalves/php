<?php
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['descricao'])) {

        $db = new Database();

        try {

            //
            // Download de arquivos e imagens
            //

            //lista de tipos de arquivos permitidos
            $tiposPermitidos =  array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
            
            $tamanhoPermitido   = 1024 * 1024 * 5;                                          // 5mb //tamanho máximo (em bytes)
            $imagem             = Funcoes::gerarNomeAleatorio($_FILES['imagem']['name']);   // nome original do arquivo no computador do usuario
            $imagemType         = $_FILES['imagem']['type'];                                // o tipo do arquivo
            $imagemSize         = $_FILES['imagem']['size'];                                // o tamanho do arquivo
            $imagemTemp         = $_FILES['imagem']['tmp_name'];                            // o nome temporario do arquivo
            $imagemError        = $_FILES['imagem']['error'];                               // codigos de possiveis erros na imagem

            $upload             = false;
            $msgError           = "";

            if ($imagemError === 0) {
                //veririca o tipo de arquivo enviado
                if (array_search($imagemType, $tiposPermitidos) === false) {
                    $msgError = "O tipo de arquivo enviado é inválido! (" . $imagem . ")";
                } else if ($imagemSize > $tamanhoPermitido) { //veririca o tamanho doa rquivo enviado
                    $msgError = "O tamanho do arquivo enviado é inválido! (" . $imagem . ")";
                } else { // não houve error, move o arquivo
                    $upload = move_uploaded_file($imagemTemp, 'uploads/produto/' . $imagem);

                    if (!$upload) {
                        $msgError = "Houve uma falha ao realizar o upload da imagem (" . $imagem . ")";
                    }
                }
            }

            if ($upload) {

                $result = $db->dbInsert("INSERT INTO produto
                                        (descricao, caracteristicas, QTD_ESTOQUE, CUSTO_TOTAL_ESTOQUE, VALOR_UNITARIO, STATUS_PRODUTO, imagem, produtocategoria_id)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                                        [
                                            $_POST['descricao'],
                                            $_POST['caracteristicas'],
                                            Funcoes::strDecimais($_POST['QTD_ESTOQUE']),
                                            Funcoes::strDecimais($_POST['CUSTO_TOTAL_ESTOQUE']),
                                            Funcoes::strDecimais($_POST['VALOR_UNITARIO']),
                                            $_POST['STATUS_PRODUTO'],
                                            $imagem,
                                            $_POST['produtocategoria_id']
                                        ]);

                if ($result) {
                    return header("Location: listaProduto.php?msgSucesso=Registro inserido com sucesso.");
                } else {
                    return header("Location: listaProduto.php?msgError=Falha ao tentar inserir o registro.");
                }
                
            } else {
                return header("Location: listaProduto.php?msgError=" . $msgError);
            }

        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaProduto.php");
    }