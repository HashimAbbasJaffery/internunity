<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello, {{ $recipient_name }}</h1>

    <p>We are from {{ $company->name }} and we invite you to submit the application in our internship which we have posted</p>
    <p>Internship Title: {{ $internship->title }}</p>
    <p>Click the link: <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}?internship_id={{ $internship->id }}</a> or Search the intership in internunity website</p>
</body>
</html>
