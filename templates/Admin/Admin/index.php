<?= $this->element('admin/header') ?>
<div class="container-fluid">
  <div class="row mt-5">
    <div class="col-md-6">
      <div class="card p-3">
        <?php if ($issetRanking > 0) { ?>
          <center>
            <h4>TOP 10 MOST ANSWERED SURVEYS</h4>
          </center>
          <table class="table table-bordered table-hover">
            <thead class="text-center">
              <td>TOP</td>
              <td>Survey</td>
              <td>Quality</td>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($ranking as $item) { ?>
                <tr class="p-2">
                  <td class="text-center"><?= $i++ ?></td>
                  <td><?= $item->question ?></td>
                  <td class="text-center"><?= $item->quanlity ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          <center>
            <h5>The rankings have not been updated yet
            </h5>
          </center>
        <?php } ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-4">
        <center class="text-uppercase">
          <h4>website data statistics
          </h4>
        </center>
        <div class="row mt-3">
          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                      Total number of categories created today
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($categoryToday as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                      Total number of categories
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($category as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total number of survies created today
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($surveyToday as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total number of survies</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($survey as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Total number of answers created today
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php foreach ($answerToday as $item) { ?> <?= $item->count ?> <?php } ?></div>
                      </div>

                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Total number of answers
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php foreach ($answer as $item) { ?> <?= $item->count ?> <?php } ?></div>
                      </div>

                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Pending Requests Card Example -->
          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      Total number of users regiter today</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($userToday as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      Total number of users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php foreach ($user as $item) { ?> <?= $item->count ?> <?php } ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<?= $this->element('admin/footer') ?>