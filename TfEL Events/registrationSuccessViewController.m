//
//  registrationSuccessViewController.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "registrationSuccessViewController.h"

#import "calendarControl.h"

#import "AppDelegate.h"

#define AppDelegate ((AppDelegate *)[UIApplication sharedApplication].delegate)

@interface registrationSuccessViewController ()

@end

@implementation registrationSuccessViewController

@synthesize addToCalendarReference, okayReference;

-(void)createErrorMessageWithLabel:(NSString *)title :(NSString *)body {
    [[[UIAlertView alloc] initWithTitle:title message:body delegate:self cancelButtonTitle:@"Okay" otherButtonTitles: nil] show];
}

- (void) createCalendarEvent {
    [calendarControl requestAccess:^(BOOL granted, NSError *error) {
        if (granted) {
            
            NSString *string = [NSString stringWithFormat:@"%@", AppDelegate.whenFrom];
            
            NSCharacterSet *notAllowedChars = [[NSCharacterSet characterSetWithCharactersInString:@"1234567890-:"] invertedSet];
            
            string = [[string componentsSeparatedByCharactersInSet:notAllowedChars] componentsJoinedByString:@""];
            
            NSDate *startDate = [calendarControl parseDate:string format:@"yyyy-MM-ddhh:mm:ss"];
            
            NSLog(@"%@, %@, %@", AppDelegate.whenStart, startDate, string);
            
            BOOL result = [calendarControl addEventAt:startDate withTitle:AppDelegate.eventName inLocation:AppDelegate.where];
            if (result) {
                NSLog(@"Event Calendar: Added success");
            } else {
                NSLog(@"Event Calendar: Failed to add to calendar");
            }
        }
        else {
            NSLog(@"Event Calendar: Access denied");
        }
    }];
}

- (void)viewWillAppear:(BOOL)animated {
    [[addToCalendarReference layer] setBorderColor:[UIColor colorWithRed:(0/255.0) green:(122/255.0) blue:(255/255.0) alpha:1].CGColor];
    [[addToCalendarReference layer] setBorderWidth:1.0f];
    [[addToCalendarReference layer] setCornerRadius:8.0f];
    [[addToCalendarReference layer] setMasksToBounds:YES];
    [[okayReference layer] setBorderColor:[UIColor colorWithRed:(0/255.0) green:(122/255.0) blue:(255/255.0) alpha:1].CGColor];
    [[okayReference layer] setBorderWidth:1.0f];
    [[okayReference layer] setCornerRadius:8.0f];
    [[okayReference layer] setMasksToBounds:YES];
}

- (void)viewDidLoad {
    [super viewDidLoad];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
}

- (IBAction)addToCalendarPress:(id)sender {
    [self createCalendarEvent];
    [self createErrorMessageWithLabel:@"Calendar Updated" :@"Event was added to your calendar."];
    
}
@end
