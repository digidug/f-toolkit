@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" href="{{ URL::to_action('styleguides@create',array('category',$styleguide->id)) }}"><i class="icon-plus"></i> Add</a>
	<div class="page-header">
		<h1>Styleguide {{ $styleguide->guid }} - {{ $styleguide->name }}</h1>
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