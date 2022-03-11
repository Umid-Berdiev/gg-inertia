@php
$romanMonths = [ "III", "VI", "IX", "XII"];
@endphp
<table>
  <style>
    sub,
    sup {
      /* Specified in % so that the sup/sup is the right size relative to the surrounding text */
      font-size: 75%;

      /* Zero out the line-height so that it doesn't interfere with the positioning that follows */
      line-height: 0;

      /* Where the magic happens: makes all browsers position the sup/sup properly, relative to the surrounding text */
      position: relative;

      /* Note that if you're using Eric Meyer's reset.css, this is already set and you can remove this rule */
      vertical-align: baseline;
    }

    sup {
      /* Move the superscripted text up */
      top: -0.5em;
    }

    sub {
      /* Move the subscripted text down, but only half as far down as the superscript moved up */
      bottom: -0.25em;
    }
  </style>
  <thead>
    <tr>
      <th rowspan="2">№
        n/n
      </th>
      <th rowspan="2" style="width: 20px">№Пробы полевой</th>
      <th rowspan="2">Местоположение
        водопункта
      </th>
      <th colspan="2">Физические свойства</th>
      <th rowspan="2">Жест-кость общая</th>
      <th rowspan="2" style="width: 40px">рН</th>
      <th rowspan="2">Сухой остаток</th>
      <th rowspan="2" style="width: 20px">Окисляемость</th>
      <th>СО2
        св
      </th>
      <th rowspan="2" style="width: 20px">Н2S, мг/л</th>
      <th rowspan="2">SiO2
        мг/л
      </th>
      <th rowspan="2" style="width: 40px">Форма вы-ра-же-ния <br>
        ре-зульта-тов
      </th>
      <th colspan="6">Анионы</th>
      <th rowspan="2">A сум-ма ани-онов</th>
      <th colspan="7">Катионы</th>
      <th rowspan="2">К сум-ма ка-тио-нов</th>
      <th rowspan="2" style="width: 40px">F – фтор, мг/л</th>
      <th rowspan="2">Формула <br>
        солевого <br>
        состава воды <br>
        (в % мг/экв)
      </th>
      <th rowspan="2" style="width: 40px">Na на пл.фот., мг/л</th>

    </tr>
    <tr>
      <th style="width: 20px">Наимено-ва-ние</th>
      <th style="width: 20px">Ха-рак-те-ри-сти-ка</th>
      <th>
        СО2
        агр.
      </th>
      <th style="width: 40px">
        Карбонат ион
        СО
      </th>
      <th style="width: 40px">
        Гидрокар ион
        HCO3
      </th>
      <th style="width: 40px">
        Хлор ион Cl
      </th>
      <th style="width: 40px">
        Сульфат ион SO
      </th>
      <th style="width: 40px">
        Нитрат ион NO3
      </th>
      <th style="width: 40px">
        Нитрит ион NO2
      </th>
      <th style="width: 40px">Кальций ион Са</th>
      <th style="width: 40px">Магний ион Mg</th>
      <th style="width: 40px">Натрий ион Na</th>
      <th style="width: 40px">Калий ион К</th>
      <th style="width: 40px">Железо
        окисное Fe2
      </th>
      <th style="width: 40px">Железо
        окисное Fe3 Аммоний ион NH4
      </th>
      <th style="width: 40px">Аммоний ион NH4</th>
    </tr>
    <tr>
      @for($i = 1; $i <= 31;$i++) <td>{{$i}}</td>
        @endfor
    </tr>

  </thead>
  <tbody>
    @forelse($data as $key=>$item)
    <tr>
      <td rowspan="3">{{ $key +1 . $item->month . " " . $item->year }}</td>
      <td rowspan="3"></td>
      <td rowspan="3">{{$item->skvajina->location}}</td>
      <td rowspan="3"></td>
      <td rowspan="3"></td>
      <td rowspan="3">{{$item->hardness}}</td>
      <td rowspan="3">{{$item->pH}}</td>
      <td rowspan="3">{{$item->dry_residue}}</td>
      <td rowspan="3"></td>
      <td rowspan="3"></td>
      <td rowspan="3"></td>
      <td rowspan="3"></td>
      <td>мг/л</td>
      <td>{{$item->CO3}}</td>
      <td>{{$item->HCO3}}</td>
      <td>{{$item->CI}}</td>
      <td>{{$item->SO4}}</td>
      <td>{{$item->NO3}}</td>
      <td>{{$item->NO2}}</td>
      <td>{{ GetSumms([$item->CO3,$item->HCO3,$item->CI,$item->SO4,$item->NO3,$item->NO2])}}</td>
      <td>{{$item->Ca}}</td>
      <td>{{$item->Mg}}</td>
      <td>{{$item->Na}}</td>
      <td>{{$item->K}}</td>
      <td>{{$item->Fe+2}}</td>
      <td>{{$item->Fe+3}}</td>
      <td>{{$item->NH4}}</td>
      <td>{{ GetSumms([$item->Ca,$item->Mg,$item->Na,$item->K,$item->Fe+2+$item->Fe+3+$item->NH4]) }}</td>
      <td rowspan="3">{{$item->F}}</td>
      <td rowspan="3">{!! $item->dry_residue / 1000 .''.GetTotalEl([
        'CO3'=>$item->CO3 > 0 ?($item->CO3 / 30 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100 : 0,
        'HCO3'=>$item->HCO3 > 0 ? ($item->HCO3 / 61 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100: 0,
        'CI'=>$item->CI > 0 ?($item->CI / 35.45 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100: 0,
        'SO4'=>$item->SO4 > 0 ?($item->SO4 / 48 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100: 0,
        'NO3'=>$item->NO3 > 0 ?($item->NO3 / 62 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100: 0,
        'NO2'=>$item->NO2 > 0 ?($item->NO2 / 46 / GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45,
        $item->SO4 / 48,$item->NO3 / 62, $item->NO2 / 46])) * 100: 0]).' / '.
        GetTotalEl([
        'Ca'=>$item->Ca > 0 ?($item->Ca / 20 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0,
        'Mg'=>$item->Mg > 0 ?($item->Mg / 12.16 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0,
        'Na'=>$item->Na > 0 ?($item->Na / 23 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0,
        'K'=>$item->K > 0 ?($item->K / 39.1 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0 ,
        'Fe2'=>$item->Fe+2 > 0 ?($item->Fe+2 / 27.78 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23,
        $item->K / 39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0,
        'Fe3'=>$item->Fe+3 > 0 ?($item->Fe+3 / 18.7 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23,
        $item->K / 39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0,
        'NH4'=>$item->NH4 > 0 ?($item->NH4 / 18.04 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K
        / 39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100: 0
        ]).'(Na+K)'.($item->Na + $item->K)
        !!}</td>
      <td rowspan="3">{{$item->Na}}</td>
    </tr>
    <tr>
      <td>мг-экв/л</td>
      <td>{{$item->CO3 / 30}}</td>
      <td>{{$item->HCO3 / 61}}</td>
      <td>{{$item->CI / 35.45 }}</td>
      <td>{{$item->SO4 / 48}}</td>
      <td>{{$item->NO3 / 62}}</td>
      <td>{{$item->NO2 / 46}}</td>
      <td>{{ GetSumms([$item->CO3 / 30,$item->HCO3 / 61,$item->CI / 35.45, $item->SO4 / 48,$item->NO3 / 62, $item->NO2 /
        46]) }}</td>
      <td>{{$item->Ca / 20}}</td>
      <td>{{$item->Mg / 12.16}}</td>
      <td>{{$item->Na / 23}}</td>
      <td>{{$item->K / 39.1}}</td>
      <td>{{$item->Fe+2 / 27.78}}</td>
      <td>{{$item->Fe+3 / 18.7}}</td>
      <td>{{$item->NH4 / 18.04}}</td>
      <td>{{ GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 / 27.78,$item->Fe+3
        / 18.7,$item->NH4 / 18.04]) }}</td>


    </tr>
    <tr>
      <td>%-экв/л</td>
      <td>{{ $item->CO3 > 0 ? ($item->CO3 / 30 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ $item->HCO3 > 0 ? ($item->HCO3 / 61 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ $item->CI > 0 ? ($item->CI / 35.45 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ $item->SO4 > 0 ? ($item->SO4 / 48 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ $item->NO3 > 0 ? ($item->NO3 / 62 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ $item->NO2 > 0 ? ($item->NO2 / 46 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0 }}</td>
      <td>{{ GetSumms([
        $item->CO3 / 30 > 0 ?($item->CO3 / 30 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0,
        $item->HCO3 / 30 > 0 ? ($item->HCO3 / 61 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0,
        $item->CI / 30 > 0 ? ($item->CI / 35.45 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0,
        $item->SO4 / 30 > 0 ? ($item->SO4 / 48 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0,
        $item->NO3 / 30 > 0 ? ($item->NO3 / 62 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0,
        $item->NO2 / 30 > 0 ?($item->NO2 / 46 / GetSumms([$item->CO3 > 0 ? $item->CO3 / 30 : 0,$item->HCO3 > 0 ?
        $item->HCO3 / 61 : 0,$item->CI > 0 ? $item->CI / 35.45 : 0, $item->SO4 > 0 ? $item->SO4 / 48 : 0,$item->NO3 > 0
        ? $item->NO3 / 62 : 0, $item->NO2 > 0 ? $item->NO2 / 46 : 0])) * 100 : 0]) }}</td>
      <td>{{$item->Ca > 0 ? ($item->Ca / 20 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->Mg > 0 ? ($item->Mg / 12.16 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->Na > 0 ? ($item->Na / 23 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->K > 0 ? ($item->K / 39.1 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->Fe+2 > 0 ? ($item->Fe+2 / 27.78 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K
        / 39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->Fe+3 > 0 ? ($item->Fe+3 / 18.7 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K
        / 39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{$item->NH4 > 0 ? ($item->NH4 / 18.04 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K /
        39.1, $item->Fe+2 / 27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100 : 0}}</td>
      <td>{{ GetSumms([
        ($item->Ca / 20 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->Mg / 12.16 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->Na / 23 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->K / 39.1 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->Fe+2 / 27.78 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->Fe+3 / 18.7 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100,
        ($item->NH4 / 18.04 / GetSumms([$item->Ca / 20,$item->Mg / 12.16,$item->Na / 23, $item->K / 39.1, $item->Fe+2 /
        27.78,$item->Fe+3 / 18.7,$item->NH4 / 18.04])) * 100]) }}</td>
    </tr>
    @empty
    @endforelse
  </tbody>
</table>
