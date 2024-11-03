<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> <!-- Add another font if desired -->
    <style>
        body {
            font-family: 'Allerta', sans-serif; /* Main font for the body */
        }
        h1 {
            font-size: 18px; /* Set the font size for the h1 element */
            font-family: 'Roboto', sans-serif; /* Change font for h1 */
        }
    </style>
</head>
@extends('layout.sidebar') <!-- Ensure this is the correct path to your sidebar layout -->
@section('content')
    <h1>Dashboard</h1>
@endsection
</html>
