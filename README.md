# Plugin Moodle

# Importação em Massa de Imagens de Cursos

Este plugin permite importar a imagem do curso em massa, apenas informando o nome breve do curso e a imagem para a importação.

## Requisitos

Moodle versão 4.1.13

## Funcionalidades

Importa imagens para múltiplos cursos de uma só vez

- Identifica cursos pelo nome breve (shortname)
- Relatório detalhado após a importação
- Interface simples e intuitiva
- Suporte para diferentes formatos de imagem
- Disponível em inglês e português do Brasil

- Este plugin foi desenvolvido especificamente para o Moodle 4.1.13 e segue as diretrizes de desenvolvimento do Moodle.

## Como usar o plugin

1. Prepare um arquivo ZIP contendo:

Um arquivo CSV chamado courses.csv com duas colunas:

- Nome breve do curso (shortname)

- Nome do arquivo de imagem

Exemplo de estrutura do arquivo courses.csv:

```csv
Copyshortname,imagefile
MATEMATICA101,matematica.jpg
HISTORIA202,historia.png
CIENCIAS303,ciencias.jpg
```

Arquivos de imagem referenciados no CSV.

Requisitos das Imagens: Devem estar no formato suportado pelo Moodle (JPG, PNG, GIF).

Certifique-se de que está adicionando os arquivos diretamente no ZIP e não em uma pasta dentro do ZIP.

Certifique-se de que o arquivo CSV está usando a codificação correta (UTF-8 é recomendado).
Verifique se não há caracteres especiais no nome do arquivo.

2. No painel do administrador, acesse:

Administração > Cursos > Importação em Massa de Imagens de Cursos


3. Faça upload do arquivo ZIP e clique em "Importar".

O sistema processará as imagens e mostrará um relatório com os resultados da importação.