{{-- <!DOCTYPE html>
<html>
<head>
    <title>All Questions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Question</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('questions.index') }}">Question</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('responses.create') }}">Response</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('post.post_order') }}" tabindex="-1" aria-disabled="true">Post Order</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>



<div class="container">
    <h2>All Questions</h2>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <a href="{{ route('questions.create') }}" class="btn btn-dark">Add Question</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Question Text</th>
                    <th>Answer Type</th>
                    <th>Options</th>
                </tr>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>{{ $question->answer_type }}</td>
                        <td>
                            @if ($question->answer_type === 'dropdown' || $question->answer_type === 'radio' || $question->answer_type === 'checkbox')
                                <ul>
                                    @foreach (json_decode($question->options, true) as $option)
                                        <li>{{ $option['option'] }}</li>
                                    @endforeach
                                </ul>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <title>All Questions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Question</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('questions.index') }}">Question</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('responses.create') }}">Response</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('post.post_order') }}" tabindex="-1" aria-disabled="true">Post Order</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

<div class="container">
    <h2>All Questions</h2>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('questions.create') }}" class="btn btn-dark">Add Question</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Question Text</th>
                    <th>Answer Type</th>
                    <th>Options</th>
                </tr>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>{{ $question->answer_type }}</td>
                        <td>
                            @if ($question->answer_type === 'dropdown' || $question->answer_type === 'radio' || $question->answer_type === 'checkbox')
                                <ul>
                                    @foreach (json_decode($question->options, true) as $option)
                                        <li>{{ $option['option'] }} - ${{ $option['price'] }}</li>
                                    @endforeach
                                </ul>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>
</html>

