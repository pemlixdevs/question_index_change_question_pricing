<!DOCTYPE html>
<html>
<head>
    <title>Create Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Create Question</h2>

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

    <div class="card">
        <div class="card-header">
            <a href="{{ route('questions.index') }}" class="btn btn-info">Question Index</a>
        </div>
        <div class="card-body">
            <form action="{{ route('questions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="question_text">Question Text:</label>
                    <input type="text" class="form-control" id="question_text" name="question_text" required>
                </div>
                <div class="form-group">
                    <label for="answer_type">Answer Type:</label>
                    <select class="form-control" id="answer_type" name="answer_type" required>
                        <option value="dropdown">Dropdown</option>
                        <option value="text">Text</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="options">Options:</label>
                    <div id="options-container">
                        <div class="option-row">
                            <input type="text" class="form-control" name="options[0][option]" placeholder="Option">
                            <input type="number" class="form-control" name="options[0][price]" placeholder="Price">
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-option">Add Option</button>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-option').addEventListener('click', function () {
        var container = document.getElementById('options-container');
        var optionCount = container.children.length;
        var div = document.createElement('div');
        div.className = 'option-row';
        div.innerHTML = '<input type="text" class="form-control" name="options[' + optionCount + '][option]" placeholder="Option">' +
                        '<input type="number" class="form-control" name="options[' + optionCount + '][price]" placeholder="Price">';
        container.appendChild(div);
    });
</script>
</body>
</html>
