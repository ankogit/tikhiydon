<?php
include('db_fns.php'); //����������� ����� � ���������
db_connect(); //����������� � ��

 if (!empty($module) && empty($Param['id'])) {



$products_for_module=GetProducts($module);

foreach ($products_for_module as $single_product):
  echo $single_product['title']; //��������
  echo $single_product['description']; //��������
 /* echo $single_product['color_1']; //������ ���� ������
  if (!empty($single_product['color_2'])) echo $single_product['color_2'];//������ ����(���� ����)
  if (!empty($single_product['color_3'])) echo $single_product['color_3'];//������ ����(���� ����)
  echo $single_product['material']; //��������, �� �������� ������ �����
  echo $single_product['c1_img1']; //������ �� ����1 ��������1. ��� ������ : 'images/shkaf10/c1_img1.jpg'
  echo $single_product['c1_img2']; //������ �� ����1 ��������2
  if (!empty($single_product['c2_img1'])) echo $single_product['c2_img1];
  if (!empty($single_product['c2_img2'])) echo $single_product['c2_img2'];
  if (!empty($single_product['c3_img1'])) echo $single_product['c3_img1'];
  if (!empty($single_product['c3_img2'])) echo $single_product['c3_img2'];
  
  //������ �� ������� ���� : 'images/shkaf10/drawing_1.jpg'
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
  echo $single_product['title']; //��������
  echo $single_product['description']; //��������
  echo $single_product['color_1']; //������ ���� ������
  if (!empty($single_product['color_2'])) echo $single_product['color_2'];//������ ����(���� ����)
  if (!empty($single_product['color_3'])) echo $single_product['color_3'];//������ ����(���� ����)
  echo $single_product['material']; //��������, �� �������� ������ �����
  echo $single_product['c1_img1']; //������ �� ����1 ��������1. ��� ������ : 'images/shkaf10/c1_img1.jpg'
  echo $single_product['c1_img2']; //������ �� ����1 ��������2
  if (!empty($single_product['c2_img1'])) echo $single_product['c2_img1'];
  if (!empty($single_product['c2_img2'])) echo $single_product['c2_img2'];
  if (!empty($single_product['c3_img1'])) echo $single_product['c3_img1'];
  if (!empty($single_product['c3_img2'])) echo $single_product['c3_img2'];
  
  //������ �� ������� ���� : 'images/shkaf10/drawing_1.jpg'
  for ($i=1;$i<=15;$i++){
  $drawing='drawing_'.$i;
  if (!empty($single_product[$drawing])) echo $single_product[$drawing];
  }
  
  
endforeach;
 }
?>