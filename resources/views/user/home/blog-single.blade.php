<section class="site-section py-lg">
    <div class="container">
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <h1 class="mb-4">There’s a Cool New Way for Men to Wear Socks and Sandals</h1>
                <div class="post-meta">
                    <span class="category">Food</span>
                    <span class="mr-2">March 15, 2018 </span> &bullet;
                    <span class="ml-2">
                        <span class="fa fa-comments"></span> 3
                    </span>
                </div>
                <div class="post-content-body">
                    <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    <p>Sint ab voluptates itaque, ipsum porro.</p>
                    <p>Quis eius aspernatur, eaque culpa cumque reiciendis.</p>
                    <div class="row mb-5">
                        <div class="col-md-12 mb-4 element-animate">
                            <img src="images/img_7.jpg" alt="Image placeholder" class="img-fluid">
                        </div>
                        <div class="col-md-6 mb-4 element-animate">
                            <img src="images/img_9.jpg" alt="Image placeholder" class="img-fluid">
                        </div>
                        <div class="col-md-6 mb-4 element-animate">
                            <img src="images/img_11.jpg" alt="Image placeholder" class="img-fluid">
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    <p>Sint ab voluptates itaque, ipsum porro.</p>
                    <p>Quis eius aspernatur, eaque culpa cumque reiciendis.</p>
                </div>

                <div class="pt-5">
                    <p>Categories: <a href="#">Food</a>, <a href="#">Travel</a>Tags: <a href="#">#manila</a>, <a href="#">#asia</a>
                    </p>
                </div>

                <div class="pt-5">
                    <h3 class="mb-5">6 Comments</h3>
                    <ul class="comment-list">
                        <li class="comment">
                            <div class="vcard">
                                <img src="images/person_1.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>Jean Doe</h3>
                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                <p>Quam voluptas earum impedit necessitatibus, nihil?</p>
                                <p><a href="#" class="reply">Reply</a></p>
                            </div>
                        </li>
                        <li class="comment">
                            <div class="vcard">
                                <img src="images/person_1.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>Jean Doe</h3>
                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                <p>Lorem ipsum dolor sit amet</p>
                                <p><a href="#" class="reply">Reply</a></p>
                            </div>

                            <ul class="children">
                                <li class="comment">
                                    <div class="vcard">
                                        <img src="images/person_1.jpg" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3>Jean Doe</h3>
                                        <div class="meta">January 9, 2018 at 2:21pm</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        <p>
                                            <a href="#" class="reply">Reply</a>
                                        </p>
                                    </div>
                                    <ul class="children">
                                        <li class="comment">
                                            <div class="vcard">
                                                <img src="images/person_1.jpg" alt="Image placeholder">
                                            </div>
                                            <div class="comment-body">
                                                <h3>Jean Doe</h3>
                                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                                <p>Lorem ipsum dolor sit amet</p>
                                                <p>
                                                    <a href="#" class="reply">Reply</a>
                                                </p>
                                            </div>

                                            <ul class="children">
                                                <li class="comment">
                                                    <div class="vcard">
                                                        <img src="images/person_1.jpg" alt="Image placeholder">
                                                    </div>
                                                    <div class="comment-body">
                                                        <h3>Jean Doe</h3>
                                                        <div class="meta">January 9, 2018 at 2:21pm</div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                        <p>
                                                            <a href="#" class="reply">Reply</a>
                                                        </p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="comment">
                            <div class="vcard">
                                <img src="images/person_1.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>Jean Doe</h3>
                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                <p><a href="#" class="reply">Reply</a></p>
                            </div>
                        </li>
                    </ul>
                    <!-- END comment-list -->

                    <!-- START new comment -->
                    <div class="comment-form-wrap pt-5">
                        <h3 class="mb-5">Leave a comment</h3>
                        <form action="#" class="p-5 bg-light">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" id="website">
                            </div>

                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Post Comment" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <!-- END new comment -->
                </div>
            </div>
            <!-- END main-content -->

            @include('user.home.sidebar')
            <!-- END sidebar -->
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-3 ">Related Post</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <a href="#" class="a-block d-flex align-items-center height-md" style="background-image: url({{ asset('images/img_2.jpg') }}); ">
                    <div class="text">
                        <div class="post-meta">
                            <span class="category">Lifestyle</span>
                            <span class="mr-2">March 15, 2018 </span> &bullet;
                            <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                        <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="#" class="a-block d-flex align-items-center height-md" style="background-image: url({{ asset('images/img_3.jpg') }}); ">
                    <div class="text">
                        <div class="post-meta">
                            <span class="category">Travel</span>
                            <span class="mr-2">March 15, 2018 </span> &bullet;
                            <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                        <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="#" class="a-block d-flex align-items-center height-md" style="background-image: url({{ asset('images/img_4.jpg') }}); ">
                    <div class="text">
                        <div class="post-meta">
                            <span class="category">Food</span>
                            <span class="mr-2">March 15, 2018 </span> &bullet;
                            <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                        <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>