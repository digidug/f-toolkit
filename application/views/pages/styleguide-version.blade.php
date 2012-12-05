@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" href="{{ URL::to_action('styleguides@create',array('category',$sg->id)) }}"><i class="icon-plus"></i> Add</a>
	<div class="page-header">
		<div class="pattern-header-left">
			<h3>{{ $styleguide->name }} Styleguide</h3>
			<h1>{{ $category->name }}</h1>
		</div>
		<div class="pattern-header-right">
			<ul>
				<li>Version <span>{{$styleguide->version()->version}}</span></li>
				<li>Date Created <span>{{ date('jS M Y',strtotime('last week')) }}</span></li>
				<li>Last Modified <span>{{ date('jS M Y') }}</span></li>
				<li>Feedback <a href="">GLSfeedback@teamdetroit.com</a></li>
			</ul>
		</div>
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
            <td>{{ $category->category()->id }}</td>
            <td><a href="{{ URL::to_action('styleguides/category', array($sg->name,$category->category()->name)); }}">{{ $category->category()->name }}</a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
@endsection