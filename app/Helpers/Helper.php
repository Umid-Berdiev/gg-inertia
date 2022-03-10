<?php

use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

if (!function_exists('kiril_to_latin')) {
  function kiril_to_latin($text)
  {
    $kirill = array('/қ/', '/ғ/', '/ў/', '/ҳ/', '/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/й/', '/к/', '/л/', '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ц/', '/ч/', '/ш/', '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/&nbsp;/', '/Қ/', '/Ғ/', '/Ў/', '/Ҳ/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/Й/', '/К/', '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ц/', '/Ч/', '/Ш/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');
    $latin = array('q', 'g`', 'o`', 'h', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'x', 'ts', 'ch', 'sh', '`', '`', 'e', 'yu', 'ya', ' ', 'Q', 'G`', 'O`', 'H', 'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'X', 'Ts', 'Ch', 'Sh', '`', '`', 'E', 'Yu', 'Ya');
    foreach ($latin as $key => $value) {
      $latin[$key] = '/' . $value . '/';
    }
    foreach ($kirill as $key => $value) {
      $kirill[$key] = str_replace("/", "", $value);
    }
    $text = str_replace("ch", "ч", $text);
    $text = str_replace("Ch", "Ч", $text);
    $text = str_replace("sh", "ш", $text);
    $text = str_replace("Sh", "Ш", $text);
    $text = str_replace("Ye", "Е", $text);


    $text = preg_replace($latin, $kirill, $text);

    $text = str_replace("г'", "ғ", $text);
    $text = str_replace("Г'", "Ғ", $text);

    $text = str_replace("О'", "Ў", $text);
    $text = str_replace("о'", "ў", $text);

    $text = str_replace("о’", "ў", $text);
    $text = str_replace("о'", "ў", $text);
    $text = str_replace("О’", "Ў", $text);
    $text = str_replace("г’", "ғ", $text);
    $text = str_replace("Г’", "Ғ", $text);
    $text = str_replace("cҳ", "ч", $text);
    $text = str_replace("Сҳ", "Ч", $text);
    $text = str_replace("йе", "е", $text);
    $text = str_replace("Йе", "Е", $text);
    $text = str_replace("йа", "я", $text);
    $text = str_replace("Йа", "Я", $text);
    $text = str_replace("сҳ", "ш", $text);
    $text = str_replace("Сҳ", "Ш", $text);
    $text = str_replace("тс", "ц", $text);
    $text = str_replace("Тс", "Ц", $text);
    $text = str_replace("йу", "ю", $text);
    $text = str_replace("Йу", "Ю", $text);
    $text = str_replace("ё’", "ё", $text);
    $text = str_replace("ё’", "ё", $text);
    $text = str_replace("ё'", "йў", $text);
    $text = str_replace("Ё’", "Ё", $text);
    $text = str_replace("’", "ъ", $text);
    $text = str_replace("&nbsp;", " ", $text);
    $text = str_replace(" Е", "Э", $text);
    $text = str_replace(" е", "э", $text);
    return $text;
  }
}

function getLocaleValue($key)
{
  $lang_id = \App\Language::where('language_prefix', app()->getLocale())->first();
  if (isset($lang_id))
    $term = \App\Term::select('mark_name')->where('id_column', $key)->where('language_id', $lang_id->id)->first();

  if (isset($term)) return $term->mark_name;

  return $key;
}

function getMonthName($month)
{
  if ($month == 1) return 'january';
  else if ($month == 2) return 'february';
  else if ($month == 3) return 'march';
  else if ($month == 4) return 'april';
  else if ($month == 5) return 'may';
  else if ($month == 6) return 'june';
  else if ($month == 7) return 'july';
  else if ($month == 8) return 'august';
  else if ($month == 9) return 'september';
  else if ($month == 10) return 'october-';
  else if ($month == 11) return 'november';
  else if ($month == 12) return 'decamber';
}

function makeLangFiles()
{
  $langs = Language::query()->get();
  // dd($langs);
  $path = base_path("resources/lang/");
  foreach ($langs as $el) {
    $words = DB::table('metkis')->where('language_id', $el->id)->get();
    // $words = Term::where('language_id', $el->id)->get();
    $text = "<?php\n\treturn [";
    foreach ($words as $word) {
      $text .= "\n\t\t\"" . $word->id_column . "\" => \"" . $word->mark_name . "\",";
    }
    $text .= "\n\t];\n?>";
    // dd($text);
    File::makeDirectory($path . $el->language_prefix, 0777, true, true);
    File::put($path . "$el->language_prefix/messages.php", $text);
  }
}

function GetSumms($arr = [])
{
  $result = 0;
  foreach ($arr as $item) {
    $result += $item;
  }
  return round($result, 2);
}

function GetTotalEl($arr = [])
{

  //    rsort($arr);
  $fin = "";
  $result = array_reverse(array_sort($arr));
  foreach ($result as $key => $item) {
    if ($item >= 10) {
      $fin .= getChemicalName($key) . '&nbsp;' . round($item, 2) . ' ';
    }
  }
  return $fin;
}

function getChemicalName($element)
{
  switch ($element) {
    case 'SO4':
      return "SO<sub>4</sub>";
    case 'NO2':
      return "NO<sub>2</sub>";
    default:
      return $element;
  }
}
