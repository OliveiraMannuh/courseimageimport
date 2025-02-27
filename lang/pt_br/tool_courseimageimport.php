<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Portuguese Brazil strings for tool_courseimageimport
 *
 * @package    tool_courseimageimport
 * @copyright  2025, Manuela Oliveira <oliveira.mannuh@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Importação em Massa de Imagens de Cursos';
$string['description'] = 'Envie um arquivo ZIP contendo imagens de cursos e um arquivo CSV (chamado courses.csv) com os nomes breves dos cursos e os nomes correspondentes dos arquivos de imagem. Formato CSV: nome_breve,arquivo_imagem';
$string['zipfile'] = 'Arquivo ZIP';
$string['zipfile_help'] = 'O arquivo ZIP deve conter um arquivo courses.csv e todos os arquivos de imagem referenciados no CSV. A primeira linha do CSV deve ser o cabeçalho, e cada linha subsequente deve ter o nome breve do curso e o nome do arquivo de imagem.';
$string['import'] = 'Importar';

$string['nozipfile'] = 'Nenhum arquivo ZIP foi enviado.';
$string['nocsvfile'] = 'O arquivo courses.csv não foi encontrado no arquivo ZIP.';
$string['cannotreadcsv'] = 'Não foi possível ler o arquivo courses.csv.';
$string['invalidrow'] = 'Linha CSV inválida';
$string['coursenotfound'] = 'Curso não encontrado';
$string['imagenotfound'] = 'Arquivo de imagem não encontrado';
$string['imagesuccess'] = 'Imagem atualizada com sucesso';
$string['imageerror'] = 'Falha ao atualizar a imagem';
$string['importresults'] = 'Importação concluída: {$a->success} com sucesso, {$a->errors} erros';