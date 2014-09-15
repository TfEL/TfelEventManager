//
//  registrationSuccessViewController.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface registrationSuccessViewController : UIViewController
@property (strong, nonatomic) IBOutlet UIButton *addToCalendarReference;
@property (strong, nonatomic) IBOutlet UIButton *okayReference;

- (IBAction)addToCalendarPress:(id)sender;

@end
