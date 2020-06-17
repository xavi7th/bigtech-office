<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  $: ({ app, salesRecords, date } = $page);

  console.log(salesRecords);
</script>

<Layout title="Sales Records | {date}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Product ID</th>
              <th scope="col">Sales Rep</th>
              <th scope="col">Ideal Price</th>
              <th scope="col">Sale Price</th>
              <th scope="col">Channel</th>
              <th scope="col">Confirmer</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">33</th>
              <td>iPhone 7+</td>
              <td>imei:EcEgAoVpL0Oc</td>
              <td>ta@fotheelects.com</td>
              <td>43,916.85</td>
              <td>71,172.96</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">35</th>
              <td>iPhone 7+</td>
              <td>imei:lpotRNva0aQbQjU</td>
              <td>zewitok@theelects.com</td>
              <td>30,316.40</td>
              <td>75,896.95</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">13</th>
              <td>iPhone 7+</td>
              <td>imei:18pH96SWElQ1O3</td>
              <td>jujritugu@entheelects.com</td>
              <td>57,386.05</td>
              <td>86,861.2</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">5</th>
              <td>iPhone 7+</td>
              <td>imei:7IfhsL</td>
              <td>nafa@theelects.com</td>
              <td>70,478.6</td>
              <td>62,040.40</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">27</th>
              <td>iPhone 7+</td>
              <td>imei:EWEIEQHvjhcfOn</td>
              <td>keecnek@ztheelects.com</td>
              <td>91,947.12</td>
              <td>54,476.50</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">20</th>
              <td>iPhone 7+</td>
              <td>imei:Y3T8At</td>
              <td>mef@gtheelects.com</td>
              <td>54,814.76</td>
              <td>57,601.67</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">11</th>
              <td>iPhone 7+</td>
              <td>imei:lgFfNShoMpHYLq9NNUG</td>
              <td>bomjivig@litheelects.com</td>
              <td>34,236.34</td>
              <td>71,223.17</td>
              <td>Facebook</td>
              <td>
                {#if false}
                  accountant@theelects.com
                {:else}
                  <button type="button" class="btn btn-warning btn-sm">
                    Confirm Payment
                  </button>
                {/if}
                &nbsp;
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
