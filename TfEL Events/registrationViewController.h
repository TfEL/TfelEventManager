//
//  registrationViewController.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface registrationViewController : UIViewController <UITextFieldDelegate>

@property (strong, nonatomic) IBOutlet UITextField *fullName;
@property (strong, nonatomic) IBOutlet UITextField *schoolName;
@property (strong, nonatomic) IBOutlet UITextField *emailAddress;
@property (strong, nonatomic) IBOutlet UITextField *phoneNumber;
@property (strong, nonatomic) IBOutlet UITextField *dietRequs;

@property (strong, nonatomic) IBOutlet UIImageView *loadingViewBackground;
@property (strong, nonatomic) IBOutlet UIActivityIndicatorView *loadingViewActivity;
@property (strong, nonatomic) IBOutlet UILabel *loadingViewLabel;

@property (strong, nonatomic) IBOutlet UIButton *registerButtonOutlet;

@property (strong, nonatomic) NSDictionary *returnedJson;

- (IBAction)registerButtonPress:(id)sender;

@end
