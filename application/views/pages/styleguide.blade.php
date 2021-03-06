@layout('templates.main')
@section('content')
	<div class="page-header">
		<div class="pull-right">
			<a class="btn btn-success" href="{{ URL::to_action('styleguides@create',array('category',$styleguide->id)) }}"><i class="icon-plus"></i> Add Category</a>
			<a class="btn btn-primary" href="{{ URL::to_action('styleguides@edit',array('styleguide',$styleguide->id)) }}"><i class="icon-edit"></i> Edit Styleguide</a>
		</div>
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