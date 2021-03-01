<script>
  import { InertiaLink,page } from '@inertiajs/inertia-svelte';


  export let most_recent_sales;
</script>

<style>
  .card-title{
      text-align: center;
    }
    .card-text{
      font-size: 0.7em;
    }
</style>
<div class="card">
  <img src="/img/sold.png" class="card-img-top" alt="">
  <div class="card-body">
      <h5 class="card-title h2">Last 5 sold items</h5>
      <p class="card-text">This lists the latest sales records along with the sales rep that handled the sales.</p>
  </div>
  <ul class="list-group list-group-flush">
        {#each  most_recent_sales as record}
        <li class="list-group-item">
          <h4 class="my-0 text-capitalize">
            <InertiaLink href={route($page.props.auth.user.user_type + '.multiaccess.products.view_product_details', record.uuid)} >{record.desc}</InertiaLink> sold by {record.sales_rep}
          </h4>
        </li>
      {/each}
  </ul>
  <!-- <div class="card-body">
      <div class="mnt-5 mnb-5">
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
      </div>
  </div> -->
</div>
