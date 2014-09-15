//
//  moreDetailsViewController.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface moreDetailsViewController : UIViewController <UIWebViewDelegate>

@property (strong, nonatomic) IBOutlet UIWebView *webView;
@property (strong, nonatomic) IBOutlet UIActivityIndicatorView *activityView;

@end
