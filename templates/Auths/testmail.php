<div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal Heading</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"  id="exampleInputEmail" placeholder="Email Address" style="border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="phone" id="exampleInputEmail" placeholder="Your Phone" style="border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="Password" style="border: 1px solid #ccc;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="created" value="<?= date('Y-m-d h:m:s') ?>">
                                    <input type="hidden" name="modified" value="<?= date('Y-m-d h:m:s') ?>">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Submit
                                    </button>
                                    <hr>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>