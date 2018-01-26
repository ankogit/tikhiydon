<?php
include('db_fns.php'); //подключение файла с функциями
db_connect(); //подключение к бд

 if (!empty($module) && empty($Param['id'])) {



$products_for_module=GetProducts($module);

foreach ($products_for_module as $single_product):
  echo $single_product['title']; //название
  echo $single_product['description']; //описание
 /* echo $single_product['color_1']; //первый цвет товара
  if (!empty($single_product['color_2'])) echo $single_product['color_2'];//второй цвет(если есть)
  if (!empty($single_product['color_3'])) echo $single_product['color_3'];//третий цвет(если есть)
  echo $single_product['material']; //материал, из которого сделан товар
  echo $single_product['c1_img1']; //ссылка на Цвет1 Картинка1. Вид ссылки : 'images/shkaf10/c1_img1.jpg'
  echo $single_product['c1_img2']; //ссылка на Цвет1 Картинка2
  if (!empty($single_product['c2_img1'])) echo $single_product['c2_img1];
  if (!empty($single_product['c2_img2'])) echo $single_product['c2_img2'];
  if (!empty($single_product['c3_img1'])) echo $single_product['c3_img1'];
  if (!empty($single_product['c3_img2'])) echo $single_product['c3_img2'];
  
  //ссылки на чертежи вида : 'images/shkaf10/drawing_1.jpg'
  for ($i=1;$i<=15;$i++){
  $drawing='drawing_'.$i;
  if (!empty($single_product[$drawing])) echo $single_product[$drawing];
  } */
  
  
endforeach;


 }
 
 
 else if(!empty($module) && !empty($Param['id'])) {
 $id=$Param['id'];
 $single_product=GetSingleProduct($module,$Param);
 
 foreach ($products_for_module as $single_product):
  echo $single_product['title']; //название
  echo $single_product['description']; //описание
  echo $single_product['color_1']; //первый цвет товара
  if (!empty($single_product['color_2'])) echo $single_product['color_2'];//второй цвет(если есть)
  if (!empty($single_product['color_3'])) echo $single_product['color_3'];//третий цвет(если есть)
  echo $single_product['material']; //материал, из которого сделан товар
  echo $single_product['c1_img1']; //ссылка на Цвет1 Картинка1. Вид ссылки : 'images/shkaf10/c1_img1.jpg'
  echo $single_product['c1_img2']; //ссылка на Цвет1 Картинка2
  if (!empty($single_product['c2_img1'])) echo $single_product['c2_img1'];
  if (!empty($single_product['c2_img2'])) echo $single_product['c2_img2'];
  if (!empty($single_product['c3_img1'])) echo $single_product['c3_img1'];
  if (!empty($single_product['c3_img2'])) echo $single_product['c3_img2'];
  
  //ссылки на чертежи вида : 'images/shkaf10/drawing_1.jpg'
  for ($i=1;$i<=15;$i++){
  $drawing='drawing_'.$i;
  if (!empty($single_product[$drawing])) echo $single_product[$drawing];
  }
  
  
endforeach;
 }
?>