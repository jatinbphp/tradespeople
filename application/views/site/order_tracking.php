<?php
include 'include/header.php';
$get_commision = $this->common_model->get_commision();
?>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
	img {
		display: block;
		max-width: 100%;
	}
	
	.faicon{
		font-size: 30px;
	}

	.timeline {
		width: 85%;
		max-width: 700px;
		margin-left: auto;
		margin-right: auto;
		display: flex;
		flex-direction: column;
		padding: 32px 0 32px 32px;
		border-left: 2px solid #000;
		font-size: 1.125rem;
	}

	.timeline-item {
		display: flex;
		gap: 24px;
		& + * {
			margin-top: 24px;
		}
		& + .extra-space {
			margin-top: 48px;
		}
	}

	.new-comment {
		width: 100%;
		input {
			border: 1px solid #f1f1f1 ;
			border-radius: 6px;
			height: 48px;
			padding: 0 16px;
			width: 100%;
			&::placeholder {
				color: var(--c-grey-300);
			}

			&:focus {
				border-color: var(--c-grey-300);
				outline: 0; // Don't actually do this
				box-shadow: 0 0 0 4px var(--c-grey-100);
			}
		}
	}

	.timeline-item-icon {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 40px;
		height: 40px;
		border-radius: 50%;
		margin-left: -52px;
		flex-shrink: 0;
		overflow: hidden;
		box-shadow: 0 0 0 6px #fff;
		svg {
			width: 20px;
			height: 20px;
		}

		&.faded-icon {
			background-color: #f1f1f1;
			color: var(--c-grey-400);
		}

		&.filled-icon {
			background-color: #f1f1f1;
			color: #fff;
		}
	}

	.timeline-item-description {
		display: flex;
		padding-top: 6px;
		gap: 8px;
		color: var(--c-grey-400);

		img {
			flex-shrink: 0;
		}
		a {
			color: var(--c-grey-500);
			font-weight: 500;
			text-decoration: none;
			&:hover,
			&:focus {
				outline: 0; // Don't actually do this
				color: var(--c-blue-500);
			}
		}
	}

	.avatar {
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		overflow: hidden;
		aspect-ratio: 1 / 1;
		flex-shrink: 0;
		width: 40px;
		height: 40px;
		&.small {
			width: 28px;
			height: 28px;
		}

		img {
			object-fit: cover;
		}
	}

	.comment {
		margin-top: 12px;
		color: var(--c-grey-500);
		border: 1px solid var(--c-grey-200);
		box-shadow: 0 4px 4px 0 var(--c-grey-100);
		border-radius: 6px;
		padding: 16px;
		font-size: 1rem;
	}

	.button {
		border: 0;
		padding: 0;
		display: inline-flex;
		vertical-align: middle;
		margin-right: 4px;
		margin-top: 12px;
		align-items: center;
		justify-content: center;
		font-size: 1rem;
		height: 32px;
		padding: 0 8px;
		background-color: var(--c-grey-100);
		flex-shrink: 0;
		cursor: pointer;
		border-radius: 99em;

		&:hover {
			background-color: var(--c-grey-200);
		}

		&.square {
			border-radius: 50%;
			color: var(--c-grey-400);
			width: 32px;
			height: 32px;
			padding: 0;
			svg {
				width: 24px;
				height: 24px;
			}

			&:hover {
				background-color: var(--c-grey-200);
				color: var(--c-grey-500);
			}
		}
	}

	.show-replies {
		color: var(--c-grey-300);
		background-color: transparent;
		border: 0;
		padding: 0;
		margin-top: 16px;
		display: flex;
		align-items: center;
		gap: 6px;
		font-size: 1rem;
		cursor: pointer;
		svg {
			flex-shrink: 0;
			width: 24px;
			height: 24px;
		}

		&:hover,
		&:focus {
			color: var(--c-grey-500);
		}
	}

	.avatar-list {
		display: flex;
		align-items: center;
		& > * {
			position: relative;
			box-shadow: 0 0 0 2px #fff;
			margin-right: -8px;
		}
	}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include 'include/sidebar.php'; ?>				
			</div>
			<div class="col-md-9">
				<ol class="timeline">
					<li class="timeline-item">
						<span class="timeline-item-icon | faded-icon">
							<i class="fa fa-clock-o faicon"></i>
						</span>
						<div class="timeline-item-description">
							<h5>Expected delivery 5-17-2024</h5>							
						</div>
					</li>
					<li class="timeline-item">
						<span class="timeline-item-icon | faded-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
								<path fill="none" d="M0 0h24v24H0z" />
								<path fill="currentColor" d="M12 13H4v-2h8V4l8 8-8 8z" />
							</svg>
						</span>
						<div class="timeline-item-description">
							<i class="avatar | small">
								<img src="https://assets.codepen.io/285131/hat-man.png" />
							</i>
							<span><a href="#">Yoan Almedia</a> moved <a href="#">Eric Lubin</a> to <a href="#">📚 Technical Test</a> on <time datetime="20-01-2021">Jan 20, 2021</time></span>
						</div>
					</li>
					<li class="timeline-item | extra-space">
						<span class="timeline-item-icon | filled-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
								<path fill="none" d="M0 0h24v24H0z" />
								<path fill="currentColor" d="M6.455 19L2 22.5V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6.455zM7 10v2h2v-2H7zm4 0v2h2v-2h-2zm4 0v2h2v-2h-2z" />
							</svg>
						</span>
						<div class="timeline-item-wrapper">
							<div class="timeline-item-description">
								<i class="avatar | small">
									<img src="https://assets.codepen.io/285131/hat-man.png" />
								</i>
								<span><a href="#">Yoan Almedia</a> commented on <time datetime="20-01-2021">Jan 20, 2021</time></span>
							</div>
							<div class="comment">
								<p>I've sent him the assignment we discussed recently, he is coming back to us this week. Regarding to our last call, I really enjoyed talking to him and so far he has the profile we are looking for. Can't wait to see his technical test, I'll keep you posted and we'll debrief it all together!😊</p>
								<button class="button">👏 2</button>
								<button class="button | square">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
										<path fill="none" d="M0 0h24v24H0z" />
										<path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 12a5 5 0 0 0 10 0h-2a3 3 0 0 1-6 0H7z" />
									</svg>
								</button>
							</div>
							<button class="show-replies">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-forward" width="44" height="44" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M15 11l4 4l-4 4m4 -4h-11a4 4 0 0 1 0 -8h1" />
								</svg>
								Show 3 replies
								<span class="avatar-list">
									<i class="avatar | small">
										<img src="https://assets.codepen.io/285131/hat-man.png" />
									</i>
									<i class="avatar | small">
										<img src="https://assets.codepen.io/285131/winking-girl.png" />
									</i> <i class="avatar | small">
										<img src="https://assets.codepen.io/285131/smiling-girl.png" />
									</i>
								</span>
							</button>
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<?php include 'include/footer.php'; ?>