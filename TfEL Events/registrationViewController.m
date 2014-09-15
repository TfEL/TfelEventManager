//
//  registrationViewController.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "registrationViewController.h"

#import "JSONResponseSerializerWithData.h"

#import "AFNetworking.h"

#import "AppDelegate.h"

#define AppDelegate ((AppDelegate *)[UIApplication sharedApplication].delegate)

#define iPhone4 ([[UIScreen mainScreen] bounds].size.height == 480)?TRUE:FALSE

@interface registrationViewController ()

@end

@implementation registrationViewController

@synthesize fullName, schoolName, emailAddress, phoneNumber, dietRequs, loadingViewActivity, loadingViewBackground, loadingViewLabel, returnedJson, registerButtonOutlet;

-(void)createErrorMessageWithLabel:(NSString *)title :(NSString *)body {
    [[[UIAlertView alloc] initWithTitle:title message:body delegate:self cancelButtonTitle:@"Okay" otherButtonTitles: nil] show];
}

-(BOOL)submitDataProceed {
    // (NSDictionary *)returnedJson is set in the class header
    
    if([returnedJson isKindOfClass:[NSDictionary class]]) {
        NSDictionary *results = returnedJson;
        
        NSString *returnCode = [results objectForKey:@"Success"];
        
        if (returnCode == false) {
            [self createErrorMessageWithLabel:@"Registration Error" :[results objectForKey:@"message"]];
        } else {
            UIStoryboard *sb = [UIStoryboard storyboardWithName:@"Main" bundle:nil];
            UIViewController *vc = [sb instantiateViewControllerWithIdentifier:@"complete"];
            [self.navigationController pushViewController:vc animated:YES];
        }
        
    } else {
        [self createErrorMessageWithLabel:@"Serialization Error" :@"This is a system bug, please try doing what you were doing again."];
    }
    
    return YES;
}

- (void)viewWillAppear:(BOOL)animated {
    [[registerButtonOutlet layer] setBorderColor:[UIColor colorWithRed:(0/255.0) green:(122/255.0) blue:(255/255.0) alpha:1].CGColor];
    [[registerButtonOutlet layer] setBorderWidth:1.0f];
    [[registerButtonOutlet layer] setCornerRadius:8.0f];
    [[registerButtonOutlet layer] setMasksToBounds:YES];
    
    loadingViewLabel.hidden = YES;
    loadingViewBackground.hidden = YES;
    loadingViewActivity.hidden = YES;
    
    fullName.text = @"";
    schoolName.text = @"";
    emailAddress.text = @"";
    phoneNumber.text = @"";
    dietRequs.text = @"";
    
    fullName.enabled = YES;
    schoolName.enabled = YES;
    emailAddress.enabled = YES;
    phoneNumber.enabled = YES;
    dietRequs.enabled = YES;
}


- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    loadingViewLabel.hidden = YES;
    loadingViewBackground.hidden = YES;
    loadingViewActivity.hidden = YES;
    
    [[loadingViewBackground layer] setCornerRadius:8.0f];
    [[loadingViewBackground layer] setMasksToBounds:YES];
    
    if (iPhone4) {
        
    } else {
        [fullName becomeFirstResponder];
    }
}

-(BOOL)textFieldShouldReturn:(UITextField*)textField;
{
    NSInteger nextTag = textField.tag + 1;
    // Try to find next responder
    UIResponder* nextResponder = [textField.superview viewWithTag:nextTag];
    if (nextResponder) {
        // Found next responder, so set it.
        [nextResponder becomeFirstResponder];
    } else {
        // Not found, so remove keyboard.
        [textField resignFirstResponder];
    }
    return NO; // We do not want UITextField to insert line-breaks.
}

- (void)textFieldDidBeginEditing:(UITextField *)textField
{
    if (iPhone4) {
        [self animateTextField: textField up: YES];
    } else {
    
    }
}

- (void)textFieldDidEndEditing:(UITextField *)textField
{
    if (iPhone4) {
       [self animateTextField: textField up: NO];
    } else {
        
    }
}

- (void) animateTextField: (UITextField *)textField up: (BOOL) up
{
    const int movementDistance = 22;
    const float movementDuration = 0.3f;
    
    int movement = (up ? -movementDistance : movementDistance);
    
    [UIView beginAnimations: @"anim" context: nil];
    [UIView setAnimationBeginsFromCurrentState: YES];
    [UIView setAnimationDuration: movementDuration];
    self.view.frame = CGRectOffset(self.view.frame, 0, movement);
    [UIView commitAnimations];
}

-(void) touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event {
    [fullName resignFirstResponder];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)registerButtonPress:(id)sender {
    loadingViewLabel.hidden = NO;
    loadingViewBackground.hidden = NO;
    loadingViewActivity.hidden = NO;
    
    if (fullName.text.length < 1 || schoolName.text.length < 1 ||emailAddress.text.length < 1 || phoneNumber.text.length < 1) {
        [self createErrorMessageWithLabel:@"Missing Required Values" : @"Please check your entries and try again."];
        loadingViewLabel.hidden = YES;
        loadingViewBackground.hidden = YES;
        loadingViewActivity.hidden = YES;
    } else {
        // Clean up
        NSString *dietaryRequirementsString;
        if (dietRequs.text.length < 1) {
             dietaryRequirementsString = @"Nil";
        } else {
            dietaryRequirementsString = dietRequs.text;
        }
        
        NSCharacterSet *notAllowedChars = [[NSCharacterSet characterSetWithCharactersInString:@"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@.+_-"] invertedSet];
        
        NSString *fullNameString = [[fullName.text componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@"%20"];
        
        NSString *schoolNameString = [[schoolName.text componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@"%20"];
        
        dietaryRequirementsString = [[dietaryRequirementsString componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@"%20"];
        
        NSString *emailAddressString = [[emailAddress.text componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@"%20"];
        
        NSString *phoneNumberString = [[phoneNumber.text componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@"%20"];
        
        fullName.enabled = NO;
        schoolName.enabled = NO;
        dietRequs.enabled = NO;
        emailAddress.enabled = NO;
        phoneNumber.enabled = NO;
        
        NSString *requestUrl = [NSString stringWithFormat:@"https://justpast:midnight@events.tfel.edu.au/api/registration_form.php?register_event=%ld&name=%@&school=%@&email=%@&phone=%@&dietary=%@", (long)AppDelegate.eventidentifier, fullNameString, schoolNameString, emailAddressString, phoneNumberString, dietaryRequirementsString];
        
        NSLog(@"%@", requestUrl);
        
        AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
        
        // Specify the API GET Str
        NSString *apiGetUrl = requestUrl;
        
        // Start doing SOMETHING :)
        [manager GET:apiGetUrl parameters:nil success:^(AFHTTPRequestOperation *operation, id responseObject) {
            NSLog(@"JSON: %@", responseObject);
            self.returnedJson = (NSDictionary *)responseObject;
            // Got it!
            manager.responseSerializer = [JSONResponseSerializerWithData serializer];
            [self submitDataProceed];
        } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
            NSLog(@"Error: %@", error);
            [self createErrorMessageWithLabel:@"Network Error" :[NSString stringWithFormat:@"Network connectivity issue. \n Check your WiFi or 3G connection.\n\nAre you using a LearnLink powered network? You'll need to unblock https://events.tfel.edu.au, and https://api.tfel.edu.au.\n\n%@", [error localizedDescription]]];
        }];
    }
}
@end
