//
//  eventsListTableViewController.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface eventsListTableViewController : UITableViewController <UITableViewDelegate, UITableViewDataSource> {
    NSMutableArray *eventsArray;
}

//@property (nonatomic, retain) UITableView *tableView;

@property (strong, nonatomic) NSDictionary *returnedJson;

@property (strong, nonatomic) IBOutlet UITableView *tableView;

@property (strong, nonatomic) IBOutlet UIBarButtonItem *offlineButtonOutlet;

- (IBAction)refreshRequested:(id)sender;

- (IBAction)offlineButton:(id)sender;

@end
