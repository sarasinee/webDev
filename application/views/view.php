<main class="container mx-auto mt-6 px-4">
    <article class="bg-white rounded-lg shadow-md">
        <img src="<?=base_url().'assets/images/'.$post->cover ?>" alt="Article Image" class="w-full rounded-t-lg">
        <div class="p-6">
            <h1 class="text-3xl font-semibold text-gray-800"><?=$post->title ?></h1>
            <p class="text-gray-600 mt-2">Published on <?=$post->date ?></p>
            <div class="mt-4 prose">
              <?=$post->content; ?>
</div>
        </div>
    </article>
<br>
</main>
