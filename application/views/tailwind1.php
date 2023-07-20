    <main class="container mx-auto mt-6 px-4">

        <div class="bg-blue-500 text-white py-4 px-6 flex items-center">
  <img src="<?=base_url() ?>/assets/images/8-FROKSEfrO6B8L8b.png" alt="Banner Image" class="w-20 h-20 rounded-full mr-4">
  <div>
    <h2 class="text-lg font-bold">Welcome to Our Website</h2>
    <p class="text-sm">Get ready to explore our amazing services!</p>
  </div>
</div>
  <br>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
           
            <?php
               foreach($post as $data) { ?>
                <div class="bg-white rounded-lg shadow-md">
                <img src="<?=base_url('assets/images/'.$data->cover) ?>" alt="Blog Post" class="w-full rounded-t-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800"><?=$data->title ?></h2>
                    <p class="text-gray-600 mt-2">
                         <?php 
                            $words = str_word_count($data->content, 1); // Split the text into an array of words
                             $limitedWords = array_slice($words, 0, 20); // Limit the number of words
                            $limitedText = implode(' ', $limitedWords);
                            echo $limitedText;
                          ?></p>
                    <a href="<?=base_url().'index.php/articles/'.$data->slug ?>" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Read More</a>
                </div>
            </div>
      <?php }
 ?>

<!-- Repeat the above blog post card for more articles -->

        </div>

<br>
 <div class="flex items-center justify-center mt-8">
<?php echo $this->pagination->create_links(); ?>
</div>

<br>

   </main>
