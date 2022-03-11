<table>
  <thead>
    <tr>
      <th>Год</th>
      <th>Кадастровый номер скважин</th>
      <th>Январь</th>
      <th>Февраль</th>
      <th>Март</th>
      <th>Апрель</th>
      <th>Май</th>
      <th>Июнь</th>
      <th>Июль</th>
      <th>Август</th>
      <th>Сентябрь</th>
      <th>Октябрь</th>
      <th>Ноябрь</th>
      <th>Декабрь</th>
    </tr>
    <tr>
      <th>year</th>
      <th>cadaster_number</th>
      <th>I</th>
      <th>II</th>
      <th>III</th>
      <th>IV</th>
      <th>V</th>
      <th>VI</th>
      <th>VII</th>
      <th>VIII</th>
      <th>IX</th>
      <th>X</th>
      <th>XI</th>
      <th>XII</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($data as $value)
    <tr>
      <td>{{ $value->year }}</td>
      <td>{{ $value->well ? $value->well->cadaster_number : null }}</td>
      <td>{{ $value->january }}</td>
      <td>{{ $value->february }}</td>
      <td>{{ $value->march }}</td>
      <td>{{ $value->april }}</td>
      <td>{{ $value->may }}</td>
      <td>{{ $value->june }}</td>
      <td>{{ $value->july }}</td>
      <td>{{ $value->august }}</td>
      <td>{{ $value->september }}</td>
      <td>{{ $value->october }}</td>
      <td>{{ $value->november }}</td>
      <td>{{ $value->december }}</td>
    </tr>
    @empty
    @endforelse
  </tbody>
</table>
