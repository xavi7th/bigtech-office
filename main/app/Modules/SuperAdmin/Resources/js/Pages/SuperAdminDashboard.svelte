<script>
  import { onMount } from "svelte";
  let name = false;

  // setInterval(function() {
  //   console.log("fired");

  //   name = !name;
  // }, 5000);

  onMount(() => {
    console.log("the component has mounted");
  });
</script>

<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{name} Super Admin App Component</div>
          <div class="card-body">I'm an from an example module.</div>
        </div>
      </div>
    </div>
  </div>
</main>

{#if name}
  <script src="/js/hello.js">

  </script>
{/if}
