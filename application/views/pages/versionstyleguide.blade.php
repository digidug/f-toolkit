@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>Styleguide {{ $styleguide->guid }} - {{ $styleguide->name }} <small>Version {{$styleguide->version()->version}}</small></h1>
	</div>
	<table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
          <tr>
            <td>{{ $category->id }}</td>
            <td><a href="{{ URL::to_action('styleguides/category', array($styleguide->name,$category->name)); }}">{{ $category->name }}</a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
@endsection