<form action="post.php" method="POST">
  <div>
    quantity: <input type="number" name="num" id="">
  </div>
  <div>
    price: <input type="number" name="price" id="">
  </div>
  <div>
    discount: 10%
  </div>
  <input type="hidden" name="discount" value="10"> <!-- 検証ツール等で改竄可能なので注意 -->
  <input type="submit" value="total">
</form>