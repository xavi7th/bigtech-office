<script>
  import { toCurrency } from '@public-shared/helpers';

  export let payments_breakdown;
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
  <img src="/img/breeakdown.jpg" class="card-img-top" alt="">
  <div class="card-body">
      <h5 class="card-title h2">Daily Payments Breakdown</h5>
      <p class="card-text">Breakdown of financial transactions confirmed by the accountant in realtime.</p>
  </div>
  <ul class="list-group list-group-flush">
      {#each  Object.entries(payments_breakdown) as [bank, amount]}
        <li class="list-group-item d-flex justify-content-between"><strong class="text-capitalize">{bank}: </strong> <h4 class="my-0 mr-15">{toCurrency(amount)}</h4></li>
      {/each}
  </ul>
</div>
