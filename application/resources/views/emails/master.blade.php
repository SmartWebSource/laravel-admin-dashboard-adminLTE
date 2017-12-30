<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Email Template</title>
    </head>
    <body>
		<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%">
			<tbody>
				<tr>
					<td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                		<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
							<tbody>
								
								<tr>
									<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center;">
        								<a href="{{url('/')}}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none;">{{$appName}}</a>
    								</td>
								</tr>

								<tr>
									<td width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            			@yield('body')
									</td>
                    			</tr>
								
								<tr>
									<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
        								<table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px">
											<tbody>
												<tr>
													<td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px">
                    									<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">
															&copy; {{Carbon::now()->format('Y')}} {{$appName}}. All rights reserved.
														</p>
								                	</td>
            									</tr>
											</tbody>
										</table>
									</td>
								</tr>

							</tbody>
						</table>
					</td>
        		</tr>
			</tbody>
		</table>
	</body>
</html>