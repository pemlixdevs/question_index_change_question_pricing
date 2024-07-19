<!DOCTYPE html>
<html>
<head>
    <title>Answer Questions</title>
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
    <h2>Answer Questions</h2>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('responses.store') }}" method="POST">
        @csrf
        @foreach ($questions as $question)
            <div class="form-group">
                <label>{{ $question->question_text }}</label>
                @if ($question->answer_type === 'text' || $question->answer_type === 'date' || $question->answer_type === 'time')
                    <input type="{{ $question->answer_type }}" class="form-control" name="responses[{{ $question->id }}][response]" required>
                @elseif ($question->answer_type === 'dropdown')
                    <select class="form-control" name="responses[{{ $question->id }}][response]" required>
                        @foreach (json_decode($question->options, true) as $option)
                            <option value="{{ $option['option'] }}">{{ $option['option'] }}</option>
                        @endforeach
                    </select>
                @elseif ($question->answer_type === 'radio')
                    @foreach (json_decode($question->options, true) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="responses[{{ $question->id }}][response]" value="{{ $option['option'] }}" required>
                            <label class="form-check-label">{{ $option['option'] }}</label>
                        </div>
                    @endforeach
                @elseif ($question->answer_type === 'checkbox')
                    @foreach (json_decode($question->options, true) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="responses[{{ $question->id }}][response][]" value="{{ $option['option'] }}">
                            <label class="form-check-label">{{ $option['option'] }}</label>
                        </div>
                    @endforeach
                @endif
                <input type="hidden" name="responses[{{ $question->id }}][question_id]" value="{{ $question->id }}">
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
