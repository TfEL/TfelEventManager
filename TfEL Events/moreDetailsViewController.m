//
//  moreDetailsViewController.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "moreDetailsViewController.h"
#import "AppDelegate.h"

#define AppDelegate ((AppDelegate *)[UIApplication sharedApplication].delegate)


@interface moreDetailsViewController ()

@end

@implementation moreDetailsViewController

@synthesize webView, activityView;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    [activityView startAnimating];
    
    [webView loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:AppDelegate.detailsURL]]];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void)webViewDidStartLoad:(UIWebView *)webView {
    activityView.hidden = false;
    [activityView startAnimating];
}

-(void)webViewDidFinishLoad:(UIWebView *)webView {
    activityView.hidden = true;
}

@end
