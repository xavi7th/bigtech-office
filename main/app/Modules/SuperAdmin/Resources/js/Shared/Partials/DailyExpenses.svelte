<script>
import { toCurrency } from '@public-shared/helpers';



  export let daily_expenses_list;
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
  <img src="/img/expenses.jpg" class="card-img-top" alt="">
  <div class="card-body">
      <h5 class="card-title h2">Daily Expenes</h5>
      <p class="card-text">List of expenses and monies spent in the office today.</p>
  </div>
  <ul class="list-group list-group-flush">
      {#each  Object.entries(daily_expenses_list) as [idx, expense_details]}
        <li class="list-group-item d-flex justify-content-between"><strong class="text-capitalize">{expense_details.purpose}: </strong> <h4 class="my-0">{toCurrency(expense_details.amount)}</h4></li>
      {/each}
  </ul>
</div>
