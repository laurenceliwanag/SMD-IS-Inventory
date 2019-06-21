<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <?php

  $stopwords = ["he", "i", "my"];
  $positive = ["improve", "enhance", "developed"];
  $negative = ["unable", "misunderstand", "don't"];
  $reflection = strtolower("I have improve and enhance My programming Skills but I don't like programming very much because I misunderstand a lot of terms and unable to complete my work");
  $reflection_array =  explode(" ", $reflection);
  $stopwords_array = [];
  $positive_array = [];
  $negative_array = [];
  $countPositive = 0;
  $countNegative = 0;

  $i = 0;

  while($i <= 5){
    echo $i;
    echo "<br>";
    $i++;
    break;
  }


 /* for($i = 0; $i < count($reflection_array); $i++){
    for($w = 0; $w < count($stopwords); $w++){
       // $reflection_array.pop();
    }
  }

  for($i = 0; $i < count($reflection_array); $i++){
    echo $reflection_array[$i];
    echo "<br>";
  }

  for($i = 0; $i < count($reflection_array); $i++){
    for($p = 0; $p < count($positive); $p++){
      if($positive[$p] == $reflection_array[$i]){
        array_push($positive_array, $reflection_array[$i]);
        $countPositive++;
      }
    }
  }

  for($i = 0; $i < count($stopwords_array); $i++){
    echo $stopwords_array[$i];
  }
  echo "<br>";


  echo $countPositive;
  echo "<br>";

  for($i = 0; $i < count($reflection_array); $i++){
    for($p = 0; $p < count($negative); $p++){
      if($negative[$p] == $reflection_array[$i]){
        array_push($negative_array, $reflection_array[$i]);
        $countNegative++;
      }
    }
  }

  echo $countNegative;
  echo "<br>";

  if($countPositive >= $countNegative){
    echo "Passed";
    echo "<br>";
  }
  else if($countPositive < $countNegative){
    echo "Failed";
    echo "<br>";
  }

  echo "Positive";
  echo "<br>";

  for($i = 0; $i < count($positive_array); $i++){
    echo $positive_array[$i];
    echo "<br>";
  }

  echo "Negative";
  echo "<br>";

  for($i = 0; $i < count($negative_array); $i++){
    echo $negative_array[$i];
    echo "<br>";
  }


  $day = 4;
  switch ($day){
  case 1:
      echo "Saturday";
      break;
  case 2:
      echo "Sunday";
      break;
  case 4:
      echo "Weekend";
  }*/

















?>
</body>
</html>